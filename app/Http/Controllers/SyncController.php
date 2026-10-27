<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Memo;
use App\Models\Product;
use App\Models\Sheet;
use App\Support\DbGuard;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * SINKRONISASI dua arah untuk aplikasi Android (satu permintaan = kirim perubahan lokal + ambil perubahan server).
 *
 * KONFLIK VERSI (optimistic concurrency):
 *   Setiap data punya `version` yang naik 1 tiap diubah. Perangkat mengirim `base_version` = versi yang terakhir ia lihat.
 *   - base_version == version di server -> perubahan diterima, version naik.
 *   - base_version != version di server -> KONFLIK: server TIDAK menimpa, dan mengembalikan salinan server.
 *     Perangkat yang memutuskan penyelesaiannya (lihat sync.js): memo/tabel dua-duanya disimpan, barang/folder yang terbaru menang.
 *   - Diubah di perangkat tapi sudah dihapus di server -> data dibuat ulang (suntingan tidak hilang).
 */
class SyncController extends Controller
{
    private const MODELS = ['folders' => Folder::class, 'products' => Product::class, 'memos' => Memo::class, 'sheets' => Sheet::class];
    private const MAX_CHANGES = 100;

    public function ping(): JsonResponse
    {
        return response()->json(['ok' => true, 'time' => now()->toIso8601String()]);
    }

    public function sync(Request $r): JsonResponse
    {
        $in = $r->validate([
            'since'                 => 'nullable|date',
            'changes'               => 'nullable|array|max:' . self::MAX_CHANGES,
            'changes.*.entity'      => ['required', Rule::in(array_keys(self::MODELS))],
            'changes.*.uid'         => 'required|string|min:8|max:40',
            'changes.*.op'          => ['required', Rule::in(['upsert', 'delete'])],
            'changes.*.base_version' => 'nullable|integer|min:0',
            'changes.*.data'        => 'nullable|array',
        ]);
        $serverTime = now()->startOfSecond();                 // dicatat SEBELUM membaca: perubahan sesudahnya ikut di sinkronisasi berikut
        $since = !empty($in['since']) ? Carbon::parse($in['since']) : null;

        $results = [];
        foreach ($in['changes'] ?? [] as $c) {
            $results[] = $this->apply($c);
        }

        return response()->json([
            'server_time' => $serverTime->toIso8601String(),
            'results'     => $results,
            'changes'     => $this->pull($since),
        ]);
    }

    /* ------------------------------------------------------------------ kirim (push) */

    private function apply(array $c): array
    {
        $entity = $c['entity']; $uid = $c['uid']; $class = self::MODELS[$entity];
        $base = array_key_exists('base_version', $c) && $c['base_version'] !== null ? (int) $c['base_version'] : null;
        $res = ['entity' => $entity, 'uid' => $uid];

        try {
            $model = $class::where('client_uid', $uid)->first();

            if ($c['op'] === 'delete') {
                if (!$model) { return $res + ['status' => 'ok']; }                       // sudah terhapus
                if ($base !== null && (int) $model->version !== $base) {
                    return $res + ['status' => 'conflict', 'version' => (int) $model->version, 'record' => $this->row($entity, $model)];
                }
                DbGuard::tx(fn () => $model->delete());
                return $res + ['status' => 'ok'];
            }

            $data = $this->clean($entity, $c['data'] ?? []);

            if (!$model) {                                                              // baru, atau sudah dihapus di server -> buat (ulang)
                $model = DbGuard::tx(fn () => $class::create($data + ['client_uid' => $uid]));
                return $res + ['status' => 'ok', 'version' => (int) $model->fresh()->version, 'id' => $model->id, 'recreated' => $base !== null];
            }
            // KIRIM ULANG: respons sebelumnya hilang di jalan (internet lambat/putus) padahal server sudah menyimpan.
            //  - base kosong tetapi uid sudah ada: uid dibuat acak di perangkat, jadi ini perangkat yang sama mengirim ulang.
            //  - isi sama persis dengan yang ada di server: kiriman ulang, bukan konflik.
            $retry = $base === null || $this->same($model, $data);
            if (!$retry && (int) $model->version !== $base) {
                return $res + ['status' => 'conflict', 'version' => (int) $model->version, 'record' => $this->row($entity, $model)];
            }
            if (!$this->same($model, $data)) {
                DbGuard::tx(fn () => $model->update($data));
            }
            return $res + ['status' => 'ok', 'version' => (int) $model->fresh()->version, 'id' => $model->id];
        } catch (ValidationException $e) {
            return $res + ['status' => 'invalid', 'message' => collect($e->errors())->flatten()->first()];
        } catch (HttpResponseException $e) {                                           // pesan dari trigger database (SIGNAL)
            $j = json_decode($e->getResponse()->getContent(), true);
            return $res + ['status' => 'invalid', 'message' => $j['message'] ?? 'Data tidak valid'];
        } catch (QueryException $e) {
            if ((int) ($e->errorInfo[1] ?? 0) === 1062) {                               // dua permintaan sama bersamaan -> coba lagi sebagai ubah
                return $res + ['status' => 'retry'];
            }
            throw $e;
        }
    }

    /** Saring & validasi isi data dari perangkat (tidak ada yang dipercaya begitu saja). */
    private function clean(string $entity, array $d): array
    {
        $rules = match ($entity) {
            'folders'  => ['name' => 'required|string|max:255', 'last_opened_at' => 'nullable|date'],
            'products' => [
                'folder_uid' => 'required|string|max:40', 'date' => 'required|date', 'name' => 'required|string|max:255',
                'price' => 'required|integer|min:0', 'box_qty' => 'nullable|integer|min:0', 'small_box_qty' => 'nullable|integer|min:0',
                'selling_price' => 'required|integer|min:0', 'photo' => 'nullable|string',
            ],
            'memos'    => ['title' => 'nullable|string|max:255', 'date' => 'required|date', 'blocks' => 'nullable|array', 'from_sheet' => 'nullable|array'],
            'sheets'   => [
                'name' => 'required|string|max:255', 'rows' => 'required|integer|min:1|max:1000', 'cols' => 'required|integer|min:1|max:100',
                'cells' => 'nullable|array', 'fmt' => 'nullable|array', 'imgs' => 'nullable|array', 'filter' => 'nullable|array',
            ],
        };
        $v = Validator::make($d, $rules)->validate();
        if ($entity === 'products') {
            $fid = Folder::where('client_uid', $v['folder_uid'])->value('id');
            if (!$fid) {
                throw ValidationException::withMessages(['folder_uid' => 'Folder barang ini belum ada di server.']);
            }
            unset($v['folder_uid']);
            $v['folder_id'] = $fid;
        }
        if ($entity === 'memos') { $v['title'] = $v['title'] ?? ''; }
        return $v;
    }

    /* ------------------------------------------------------------------ ambil (pull) */

    private function pull(?Carbon $since): array
    {
        $uid = Auth::id();
        // data yang dibuat lewat web belum punya client_uid: beri sekarang (tanpa menaikkan version)
        foreach (array_keys(self::MODELS) as $t) {
            DB::table($t)->where('user_id', $uid)->whereNull('client_uid')->pluck('id')
                ->each(fn ($id) => DB::table($t)->where('id', $id)->update(['client_uid' => (string) Str::uuid()]));
        }

        $out = [];
        $folderUids = Folder::pluck('client_uid', 'id');
        foreach (self::MODELS as $entity => $class) {
            $q = $class::query()->orderBy('updated_at')->orderBy('id');
            if ($since) { $q->where('updated_at', '>=', $since); }
            foreach ($q->get() as $m) {
                $row = $this->row($entity, $m, $folderUids);
                $out[] = ['entity' => $entity, 'op' => 'upsert', 'uid' => $m->client_uid, 'version' => (int) $m->version, 'data' => $row];
            }
        }
        if ($since) {
            DB::table('sync_tombstones')->where('user_id', $uid)->where('deleted_at', '<', now()->subDays(90))->delete();   // rapikan
            $stones = DB::table('sync_tombstones')->where('user_id', $uid)->where('deleted_at', '>=', $since)->orderBy('id')->get();
            foreach ($stones as $s) {
                if ($s->client_uid) {
                    $out[] = ['entity' => $s->entity, 'op' => 'delete', 'uid' => $s->client_uid, 'version' => (int) $s->version];
                }
            }
        }
        return $out;
    }

    /** Apakah isi dari perangkat sama dengan yang sudah tersimpan? (dibandingkan setelah dinormalkan) */
    private function same($model, array $data): bool
    {
        foreach ($data as $k => $v) {
            if ($this->canon($model->getAttribute($k)) !== $this->canon($v)) {
                return false;
            }
        }
        return true;
    }

    private function canon($v): string
    {
        if ($v === null) { return ''; }
        if ($v instanceof \DateTimeInterface) { return $v->format('H:i:s') === '00:00:00' ? $v->format('Y-m-d') : (string) $v->getTimestamp(); }
        if (is_array($v)) { return json_encode($this->sortDeep($v)); }
        if (is_string($v) && preg_match('/^\d{4}-\d{2}-\d{2}T/', $v)) { return (string) Carbon::parse($v)->getTimestamp(); }
        return (string) $v;
    }

    private function sortDeep(array $a): array
    {
        foreach ($a as $k => $v) { if (is_array($v)) { $a[$k] = $this->sortDeep($v); } }
        ksort($a);
        return $a;
    }

    private function row(string $entity, $m, $folderUids = null): array
    {
        $a = $m->toArray();
        unset($a['user_id']);
        if ($entity === 'products') {
            $folderUids ??= Folder::pluck('client_uid', 'id');
            $a['folder_uid'] = $folderUids[$m->folder_id] ?? null;
        }
        return $a;
    }
}
