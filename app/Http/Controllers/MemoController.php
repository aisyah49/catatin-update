<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use App\Support\DbGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    private function rules(): array
    {
        return ['title' => 'nullable|string|max:255', 'date' => 'required|date', 'blocks' => 'nullable|array', 'from_sheet' => 'nullable|array'];
    }

    public function index(): JsonResponse
    {
        return response()->json(Memo::latest()->get());
    }

    public function store(Request $r): JsonResponse
    {
        $data = $r->validate($this->rules());
        $data['title'] = $data['title'] ?? '';
        return response()->json(DbGuard::tx(fn () => Memo::create($data)), 201);
    }

    public function update(Request $r, Memo $memo): JsonResponse
    {
        $data = $r->validate($this->rules());
        DbGuard::tx(fn () => $memo->update($data));
        return response()->json($memo->fresh());
    }

    public function destroy(Memo $memo): JsonResponse
    {
        DbGuard::tx(fn () => $memo->delete());   // snapshot dicatat trigger trg_memos_ad
        return response()->json(['deleted' => true]);
    }
}
