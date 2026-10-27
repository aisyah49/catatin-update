@verbatim
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#3B82F6">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="Catatin">
<title>Catatin — Buku Catatan Gudang</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<style>
:root{
  --bg:#F8FAFC; --white:#FFFFFF; --blue:#3B82F6; --blue-d:#1E3A8A; --blue-soft:#EFF4FE;
  --yellow:#FACC15; --ink:#1E293B; --muted:#64748B; --line:#E2E8F0; --danger:#DC2626; --green:#16A34A;
  padding-top:env(safe-area-inset-top,0px); padding-bottom:env(safe-area-inset-bottom,0px);
}
/* Terang (default) already set above. Other themes below, applied via [data-theme] on <html>. */
:root[data-theme="light"]{--bg:#F8FAFC;--white:#FFFFFF;--blue:#3B82F6;--blue-d:#1E3A8A;--blue-soft:#EFF4FE;--ink:#1E293B;--muted:#64748B;--line:#E2E8F0;}
:root[data-theme="dark"]{--bg:#0F172A;--white:#1E293B;--blue-soft:#1c2b4a;--ink:#E2E8F0;--muted:#94A3B8;--line:#334155;--blue:#60A5FA;--blue-d:#93C5FD;}
:root[data-theme="blue"]{--bg:#EAF2FF;--white:#FFFFFF;--blue:#2563EB;--blue-d:#1E3A8A;--blue-soft:#DCEAFF;--ink:#0F1E3D;--muted:#5B6B8C;--line:#C7DBFF;}
:root[data-theme="green"]{--bg:#F1FAF3;--white:#FFFFFF;--blue:#16A34A;--blue-d:#14532D;--blue-soft:#DCFCE7;--ink:#132A1B;--muted:#5C7767;--line:#CDEBD6;--yellow:#FACC15;}
:root[data-theme="sunset"]{--bg:#FFF8F0;--white:#FFFFFF;--blue:#F97316;--blue-d:#9A3412;--blue-soft:#FFEBD6;--ink:#3A2416;--muted:#8A6A50;--line:#F3DCC2;--yellow:#FACC15;}
/* Editor memo punya garis sendiri; matikan garis latar halaman supaya tidak dobel/bergeser */
.main:has(#me_blocks){background-image:none !important;}
/* color-scheme: kontrol bawaan browser (input tanggal, dll) ikut tema. --rule: garis kertas latar, lembut di tiap tema. */
:root{color-scheme:light;--rule:rgba(100,116,139,.10);--hero-a:#3B82F6;--hero-b:#1E3A8A;}
:root[data-theme="dark"]{color-scheme:dark;--rule:rgba(148,163,184,.07);--hero-a:#2563EB;--hero-b:#1E1B4B;}
:root[data-theme="blue"]{--rule:rgba(37,99,235,.08);--hero-a:#2563EB;--hero-b:#1E3A8A;}
:root[data-theme="green"]{--rule:rgba(22,163,74,.08);--hero-a:#16A34A;--hero-b:#14532D;}
:root[data-theme="sunset"]{--rule:rgba(249,115,22,.08);--hero-a:#EA580C;--hero-b:#9A3412;}
/* fallback: follow system preference only when user hasn't picked a theme */
@media (prefers-color-scheme: dark){
  :root:not([data-theme]){--bg:#0F172A;--white:#1E293B;--blue-soft:#1c2b4a;--ink:#E2E8F0;--muted:#94A3B8;--line:#334155;--blue:#60A5FA;--blue-d:#93C5FD;}
}
*{box-sizing:border-box;}
html,body{height:100%;}
body{margin:0;background:var(--bg);color:var(--ink);font-family:'Inter',sans-serif;}
h1,h2,h3,.head{font-family:'Plus Jakarta Sans',sans-serif;}
button{font-family:inherit;cursor:pointer;}
html{scroll-padding-top:env(safe-area-inset-top,0px);}

.app{display:flex;min-height:100vh;min-height:100dvh;}
.side{width:250px;flex-shrink:0;background:var(--white);border-right:1px solid var(--line);padding:18px 14px;display:flex;flex-direction:column;position:sticky;top:0;height:100vh;height:100dvh;overflow-y:auto;overscroll-behavior:contain;}
.user-box{margin-top:14px;padding:10px 6px 0;border-top:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;gap:8px;font-size:.85rem;color:var(--muted)}
.user-box .user-name{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:600;color:var(--ink)}
.brand{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:1.15rem;padding:4px 6px 14px;}
.side h4{font-size:.76rem;color:var(--blue);margin:18px 6px 8px;font-weight:700;}
.last-opened{background:var(--blue-soft);border:1px solid var(--line);border-radius:12px;padding:10px 12px;margin:0 2px;cursor:pointer;}
.last-opened .t{font-size:.7rem;color:var(--blue-d);font-weight:600;display:flex;align-items:center;gap:4px;}
.last-opened .n{font-size:.88rem;font-weight:600;margin-top:3px;}
.folder-item{display:flex;align-items:center;justify-content:space-between;gap:6px;padding:9px 10px;border-radius:10px;font-size:.87rem;font-weight:500;margin-bottom:2px;}
.folder-item:hover{background:var(--blue-soft);cursor:pointer;}
.folder-item.active{background:var(--blue);color:#fff;}
.folder-item .fname{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:flex;align-items:center;gap:7px;}
.folder-item .del{opacity:0;font-size:.75rem;padding:2px 6px;border-radius:6px;}
.folder-item:hover .del{opacity:.6;}
.folder-item .del:hover{opacity:1 !important;background:rgba(0,0,0,.08);}
.add-folder-btn{display:flex;align-items:center;gap:6px;padding:9px 10px;border-radius:10px;border:1.5px dashed var(--line);color:var(--blue);font-size:.85rem;font-weight:600;margin-top:4px;background:none;justify-content:center;}
.add-folder-btn:hover{background:var(--blue-soft);}
.side-nav{margin-top:auto;padding-top:12px;border-top:1px solid var(--line);}
.side-nav .folder-item{font-weight:600;}

.main{flex:1;min-width:0;background-color:var(--bg);background-image:repeating-linear-gradient(to bottom, transparent 0 31px, var(--rule) 31px 32px);background-attachment:local;}
.topbar{position:sticky;top:0;z-index:10;background:var(--bg);display:flex;align-items:center;gap:12px;padding:16px 22px;border-bottom:1px solid var(--line);backdrop-filter:blur(6px);}
.burger{display:none;background:none;border:none;font-size:1.4rem;color:var(--ink);}
.search-box{flex:1;position:relative;max-width:520px;}
.search-box input{width:100%;padding:10px 14px 10px 36px;border-radius:10px;border:1px solid var(--line);background:var(--white);font-size:.88rem;color:var(--ink);}
.search-box input:focus{outline:2px solid var(--blue);outline-offset:0;}
.search-box .ic{position:absolute;left:11px;top:50%;transform:translateY(-50%);opacity:.5;font-size:.9rem;}
.storage-ind{display:flex;align-items:center;gap:6px;font-size:.78rem;font-weight:600;color:var(--muted);white-space:nowrap;}
.dot{width:8px;height:8px;border-radius:50%;display:inline-block;}
.dot.green{background:var(--green);}
.dot.yellow{background:var(--yellow);}
.dot.red{background:var(--danger);}

.content{padding:22px;max-width:980px;min-width:0;}
@media(min-width:1500px){.content{margin:0 auto;max-width:1180px;padding:28px 36px;}.memo-footer .mf-in{max-width:1108px;margin:0 auto;}}
.section-title{font-size:1.35rem;font-weight:800;margin:0 0 4px;}
.section-sub{color:var(--muted);font-size:.88rem;margin-bottom:20px;}

.folder-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;margin-bottom:26px;}
.fcard{background:var(--white);border:1px solid var(--line);border-radius:3px 12px 12px 12px;padding:18px 16px 16px;cursor:pointer;transition:box-shadow .15s,transform .15s;position:relative;margin-top:10px;}
.fcard::before{content:'';position:absolute;top:-9px;left:0;width:46%;height:12px;background:var(--white);border:1px solid var(--line);border-bottom:none;border-radius:6px 6px 0 0;}
.stat-row{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-bottom:22px;}
@media(max-width:380px){.stat-row{grid-template-columns:1fr;}}
.stat-card{background:var(--white);border:1px solid var(--line);border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:12px;}
.stat-card .si{width:42px;height:42px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;}
.stat-card .si.blue{background:var(--blue-soft);}
.stat-card .si.amber{background:#FEF3C7;}
.stat-card .si.pink{background:#FCE7F3;}
:root[data-theme="dark"] .stat-card .si.amber{background:#3a2f12;}
:root[data-theme="dark"] .stat-card .si.pink{background:#3a1f2c;}
.stat-card .sb{min-width:0;}
.stat-card .sl{font-size:.74rem;color:var(--muted);font-weight:600;}
.stat-card .sn{font-size:1.5rem;font-weight:800;font-family:'Plus Jakarta Sans',sans-serif;line-height:1.2;}
.chart-card{background:var(--white);border:1px solid var(--line);border-radius:14px;padding:18px 18px 16px;margin-bottom:24px;}
.chart-card h4{font-size:.86rem;color:var(--blue);margin:0 0 14px;font-weight:700;}
.fcard:hover{box-shadow:0 6px 18px rgba(30,58,138,.10);transform:translateY(-1px);}
.fcard .icon{font-size:1.5rem;}
.fcard .fn{font-weight:700;margin-top:8px;font-size:.92rem;}
.fcard .fc{color:var(--muted);font-size:.76rem;margin-top:3px;}

.memo-preview{background:var(--white);border:1px solid var(--line);border-radius:14px;padding:16px;cursor:pointer;}
.memo-preview:hover{background:var(--blue-soft);}

.product-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:14px;}
.pcard{background:var(--white);border:1px solid var(--line);border-radius:14px;padding:15px 16px;position:relative;}
.pcard .ptop{display:flex;justify-content:space-between;align-items:flex-start;}
.pcard .pname{font-weight:700;font-size:1rem;}
.menu-btn{background:none;border:none;font-size:1.1rem;color:var(--muted);padding:2px 6px;border-radius:6px;}
.menu-btn:hover{background:var(--blue-soft);}
.menu-pop{position:absolute;right:12px;top:38px;background:var(--white);border:1px solid var(--line);border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.12);z-index:20;overflow:hidden;min-width:110px;}
.menu-pop button{display:block;width:100%;text-align:left;padding:9px 14px;background:none;border:none;font-size:.85rem;color:var(--ink);}
.menu-pop button:hover{background:var(--blue-soft);}
.menu-pop button.danger{color:var(--danger);}
.prow{display:flex;justify-content:space-between;font-size:.82rem;padding:5px 0;border-bottom:1px dashed var(--line);}
.prow:last-of-type{border-bottom:none;}
.prow .k{color:var(--muted);}
.prow .v{font-weight:600;}
.pdate{margin-top:10px;font-size:.72rem;color:var(--muted);}

.fab{position:fixed;bottom:calc(24px + env(safe-area-inset-bottom,0px));right:calc(24px + env(safe-area-inset-right,0px));background:var(--blue);color:#fff;border:none;width:54px;height:54px;border-radius:50%;font-size:1.5rem;box-shadow:0 8px 20px rgba(59,130,246,.4);display:flex;align-items:center;justify-content:center;z-index:30;}
.fab.yellow{background:var(--yellow);color:var(--blue-d);bottom:calc(90px + env(safe-area-inset-bottom,0px));}

.btn{border:none;background:var(--blue);color:#fff;padding:10px 18px;border-radius:10px;font-size:.86rem;font-weight:700;box-shadow:0 2px 0 var(--blue-d);transition:transform .08s,box-shadow .08s;}
.btn:hover{background:var(--blue-d);}
.btn:active{transform:translateY(2px);box-shadow:0 0 0 var(--blue-d);}
.btn.ghost{background:none;color:var(--ink);border:1px solid var(--line);box-shadow:none;}
.btn.ghost:hover{background:var(--blue-soft);}
.btn.ghost:active{transform:translateY(1px);box-shadow:none;}
.btn.danger{background:var(--danger);box-shadow:0 2px 0 #8f1f14;}
.btn.danger:active{box-shadow:0 0 0 #8f1f14;}
.btn.small{padding:6px 12px;font-size:.78rem;border-radius:8px;}

.overlay{position:fixed;inset:0;background:rgba(15,23,42,.45);display:flex;align-items:center;justify-content:center;z-index:100;padding:16px;}
.modal{background:var(--white);border-radius:16px;max-width:440px;width:100%;padding:22px 24px;max-height:90vh;max-height:90dvh;overflow-y:auto;overscroll-behavior:contain;}
.modal h3{margin:0 0 16px;font-size:1.1rem;}
.field{margin-bottom:13px;}
.field label{display:block;font-size:.78rem;font-weight:700;margin-bottom:5px;color:var(--muted);}
.field input,.field textarea{width:100%;padding:9px 12px;border-radius:9px;border:1px solid var(--line);background:var(--bg);color:var(--ink);font-size:.88rem;font-family:inherit;}
.field input:focus,.field textarea:focus{outline:2px solid var(--blue);}
.field-row{display:flex;gap:10px;}
.field-row .field{flex:1;}
.modal-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:16px;}
.modal.confirm p{font-size:.88rem;color:var(--muted);line-height:1.5;}
.modal.confirm .target{font-weight:700;color:var(--ink);margin:6px 0;}

.memo-item{background:var(--white);border:1px solid var(--line);border-radius:14px;padding:14px 16px;margin-bottom:10px;}
.memo-item .mt{font-weight:700;font-size:.95rem;}
.memo-item .md{font-size:.72rem;color:var(--muted);margin-top:2px;}
.memo-item .mc{font-size:.86rem;margin-top:8px;line-height:1.5;white-space:pre-wrap;overflow-x:auto;}
.memo-item .mc.mono{font-family:'JetBrains Mono',monospace,ui-monospace;font-size:.78rem;background:var(--bg);border-radius:9px;padding:10px 12px;line-height:1.6;}
.memo-table-wrap{margin-top:10px;overflow-x:auto;border:1px solid var(--line);border-radius:10px;}
table.memo-table{border-collapse:collapse;font-size:.8rem;width:100%;}
table.memo-table th,table.memo-table td{border:1px solid var(--line);padding:0;white-space:nowrap;position:relative;}
table.memo-table th{background:var(--blue-soft);color:var(--blue-d);font-weight:700;font-size:.74rem;padding:6px 10px;}
table.memo-table td.rh{background:var(--blue-soft);color:var(--muted);font-weight:700;text-align:center;padding:6px 10px;}
table.memo-table td .cellval,table.memo-table th .cellval{padding:6px 10px;min-height:20px;min-width:40px;cursor:text;outline:none;}
table.memo-table th .cellval{padding:0;}
table.memo-table .cellval[contenteditable]:focus{box-shadow:inset 0 0 0 2px var(--blue);background:var(--white);}
table.memo-table .cellval p{margin:0;}
table.memo-table .cellval[contenteditable]:hover{background:var(--blue-soft);}
table.memo-table td input{display:block;width:100%;min-width:90px;box-sizing:border-box;border:2px solid var(--blue);outline:none;border-radius:4px;padding:5px 8px;font-size:.8rem;font-family:inherit;background:var(--white);color:var(--ink);}
.memo-item.compact{padding:12px 16px;}
.memo-item .mhead{display:flex;align-items:center;gap:10px;cursor:pointer;}
.memo-item .mh-main{flex:1;min-width:0;}
.memo-item .msn{font-size:.82rem;color:var(--muted);margin-top:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.memo-item .mchev{color:var(--muted);transition:transform .15s;font-size:1rem;}
.memo-item.open .mchev{transform:rotate(180deg);}
.memo-item.open .msn{display:none;}
.memo-item .mbody{display:none;margin-top:6px;}
.memo-item.open .mbody{display:block;}
.memo-item.compact .actions{margin-top:8px;}
.memo-item .actions{display:flex;gap:6px;margin-top:10px;}

.memo-toolbar{display:flex;gap:6px;flex-wrap:wrap;margin:14px 0;padding:8px;background:var(--white);border:1px solid var(--line);border-radius:10px;overflow-x:auto;align-items:center;}
.memo-toolbar button{border:1px solid var(--line);background:var(--bg);color:var(--ink);padding:7px 11px;border-radius:8px;font-size:.82rem;flex-shrink:0;}
.memo-toolbar button:hover{background:var(--blue-soft);}
.tb-sep{width:1px;align-self:stretch;background:var(--line);margin:0 2px;flex-shrink:0;}
.memo-editor-block{min-height:120px;padding:14px 16px;background:var(--white);border:1px solid var(--line);border-radius:12px;margin-bottom:12px;font-size:.92rem;line-height:1.6;}
.memo-editor-block:focus{outline:2px solid var(--blue);outline-offset:-1px;}
.memo-editor-block p{margin:0 0 10px;}
.memo-editor-block p:last-child{margin-bottom:0;}
.memo-table-wrap[data-block]{margin-bottom:12px;}
.table-block-actions{display:flex;gap:6px;flex-wrap:wrap;padding:10px;background:var(--bg);}
.memo-checklist{background:var(--white);border:1px solid var(--line);border-radius:12px;padding:12px 14px;margin-bottom:12px;}
.chk-row{display:flex;align-items:center;gap:8px;margin-bottom:6px;}
.chk-row.ro:last-child{margin-bottom:0;}
.chk-row input[type="checkbox"]{flex-shrink:0;width:17px;height:17px;}
.chk-text{flex:1;border:none;border-bottom:1px solid var(--line);padding:5px 2px;background:none;color:var(--ink);font-size:.86rem;}
.chk-text:focus{border-color:var(--blue);outline:none;}
.chk-del{border:none;background:none;color:var(--muted);cursor:pointer;font-size:.9rem;flex-shrink:0;}
.chk-del:hover{color:var(--danger);}

.crumb{display:flex;align-items:center;gap:6px;font-size:.85rem;color:var(--blue);cursor:pointer;margin-bottom:10px;font-weight:600;}
.empty{text-align:center;padding:50px 10px;color:var(--muted);font-size:.9rem;}
.search-result-group{margin-bottom:22px;}
.search-result-group h4{font-size:.84rem;color:var(--blue);margin-bottom:10px;font-weight:700;}
.sres-item{background:var(--white);border:1px solid var(--line);border-radius:12px;padding:12px 14px;margin-bottom:8px;cursor:pointer;display:flex;justify-content:space-between;align-items:center;}
.sres-item:hover{background:var(--blue-soft);}
.toast{position:fixed;bottom:20px;left:50%;transform:translateX(-50%);background:var(--blue-d);color:#fff;padding:10px 20px;border-radius:10px;font-size:.85rem;z-index:200;opacity:0;transition:opacity .25s;pointer-events:none;}
.toast.show{opacity:1;}

/* spreadsheet */
.sheet-toolbar{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px;}
.sheet-wrap{overflow:auto;border:1px solid var(--line);border-radius:12px;background:var(--white);max-width:100%;}
table.sheet{border-collapse:collapse;font-size:.84rem;}
table.sheet th,table.sheet td{border:1px solid var(--line);padding:0;min-width:90px;position:relative;}
table.sheet th{background:var(--blue-soft);color:var(--muted);font-weight:700;font-size:.74rem;padding:6px 8px;position:sticky;top:0;z-index:2;text-align:center;}
table.sheet th.rowhead{position:sticky;left:0;z-index:3;min-width:36px;width:36px;}
table.sheet th.corner{position:sticky;left:0;top:0;z-index:4;}
table.sheet td.rowhead{position:sticky;left:0;background:var(--blue-soft);color:var(--muted);font-weight:700;text-align:center;font-size:.74rem;z-index:1;}
table.sheet td .cellimg{display:block;max-width:none;width:auto;margin:4px 6px 0;border-radius:6px;pointer-events:none;object-fit:contain;}
table.sheet td .cellval{padding:6px 8px;min-height:20px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;cursor:text;}
table.sheet td .cellval:hover{background:var(--blue-soft);}
table.sheet td.editing{z-index:40;overflow:visible;}
table.sheet td.sel{box-shadow:inset 0 0 0 2px var(--blue);background-image:linear-gradient(color-mix(in srgb,var(--blue) 14%,transparent),color-mix(in srgb,var(--blue) 14%,transparent));}
table.sheet td[data-key]{height:34px;}
table.sheet th[data-colsel],table.sheet td.rowhead[data-rowsel]{cursor:pointer;}
table.sheet th[data-colsel]:hover,table.sheet td.rowhead[data-rowsel]:hover{background:var(--line);}
.cellval.fb,table.sheet td input.fb{font-weight:700;}
.cellval.fi,table.sheet td input.fi{font-style:italic;}
.cellval.fu,table.sheet td input.fu{text-decoration:underline;}
.cellval.fx,table.sheet td input.fx{text-decoration:line-through;}
.cellval.fu.fx,table.sheet td input.fu.fx{text-decoration:underline line-through;}
.fmt-bar{margin:-4px 0 12px;align-items:center;}
.fmt-bar .btn{min-width:34px;}
.fmt-bar .btn.on{background:var(--blue);color:#fff;border-color:var(--blue);}
.fmt-info{font-size:.76rem;color:var(--muted);margin-left:4px;}
/* tombol Undo/Redo */
/* Undo/Redo: ikon SVG tebal, garis gelap, jelas terlihat */
.hist-btn{display:inline-flex;align-items:center;justify-content:center;min-width:46px;min-height:42px;padding:0 12px;line-height:1;}
.hist-btn svg{display:block;stroke-width:3;}
.memo-toolbar .hist-btn,.fmt-bar .hist-btn{border:2px solid var(--ink);color:var(--ink);background:var(--white);}
.memo-toolbar .hist-btn:hover:not(:disabled),.fmt-bar .hist-btn:hover:not(:disabled){background:var(--blue);color:#fff;border-color:var(--blue);}
.memo-src{font-size:.72rem;color:var(--muted);margin-top:3px;}
.save-status{margin-right:auto;align-self:center;font-size:.78rem;color:var(--muted);}
.memo-toolbar [data-align] svg{display:block;}
/* ===== Dashboard ===== */
.dash-hero{position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:26px 28px;border-radius:20px;background:linear-gradient(135deg,var(--hero-a),var(--hero-b));color:#fff;margin-bottom:16px;box-shadow:0 12px 30px rgba(30,58,138,.20);}
.dash-hero::before{content:'';position:absolute;right:-60px;top:-80px;width:260px;height:260px;border-radius:50%;background:rgba(255,255,255,.10);}
.dash-hero::after{content:'';position:absolute;right:130px;bottom:-95px;width:190px;height:190px;border-radius:50%;background:rgba(255,255,255,.07);}
.hero-text{position:relative;z-index:1;min-width:0;}
.hero-date{font-size:.8rem;font-weight:600;opacity:.88;}
.hero-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.75rem;font-weight:800;margin:4px 0 6px;color:#fff;line-height:1.2;}
.hero-sub{margin:0 0 14px;font-size:.9rem;opacity:.93;max-width:440px;line-height:1.5;}
.hero-cta{background:#fff;color:var(--hero-b);border:none;border-radius:999px;padding:10px 18px;font-weight:700;font-size:.84rem;cursor:pointer;box-shadow:0 4px 12px rgba(0,0,0,.18);max-width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;transition:transform .15s;}
.hero-cta:hover{transform:translateY(-1px);}
.hero-art{position:relative;z-index:1;width:170px;height:122px;flex-shrink:0;}
.art-book{position:absolute;right:18px;top:4px;font-size:4.3rem;transform:rotate(-8deg);filter:drop-shadow(0 8px 12px rgba(0,0,0,.28));}
.art-chip{position:absolute;width:42px;height:42px;border-radius:12px;background:rgba(255,255,255,.93);display:flex;align-items:center;justify-content:center;font-size:1.3rem;box-shadow:0 6px 14px rgba(0,0,0,.18);}
.art-chip.c1{left:0;top:14px;transform:rotate(-6deg);}
.art-chip.c2{left:48px;bottom:0;transform:rotate(5deg);}
.art-chip.c3{right:0;bottom:6px;transform:rotate(-4deg);}
@media(max-width:640px){.hero-art{display:none;}.dash-hero{padding:20px;}.hero-title{font-size:1.4rem;}}
.qa-row{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:16px;}
.qa-btn{display:flex;align-items:center;justify-content:center;gap:8px;padding:13px 10px;border-radius:14px;border:1.5px dashed var(--line);background:var(--white);color:var(--ink);font-weight:700;font-size:.86rem;cursor:pointer;transition:transform .15s,border-color .15s,background .15s;}
.qa-btn:hover{border-color:var(--blue);background:var(--blue-soft);transform:translateY(-1px);}
.qa-btn span{font-size:1.15rem;}
@media(max-width:480px){.qa-row{grid-template-columns:1fr;}}
.stat-row3{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px;margin-bottom:16px;}
.stat-card.click{cursor:pointer;transition:transform .15s,box-shadow .15s;}
.stat-card.click:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(0,0,0,.08);}
.dash-grid{display:grid;grid-template-columns:1.15fr 1fr;gap:14px;margin-bottom:18px;}
@media(max-width:860px){.dash-grid{grid-template-columns:1fr;}}
.dash-card{background:var(--white);border:1px solid var(--line);border-radius:16px;padding:16px 18px;}
.dash-card h4{font-size:.9rem;color:var(--blue);font-weight:700;margin:0 0 12px;}
.sec-h{font-size:.95rem;color:var(--blue);font-weight:700;margin:0 0 10px;}
.sec-h .more,.dash-card .more{float:right;font-size:.76rem;color:var(--blue);cursor:pointer;font-weight:600;}
.recent-row{display:flex;align-items:center;gap:12px;padding:9px 6px;border-radius:12px;cursor:pointer;}
.recent-row:hover{background:var(--blue-soft);}
.recent-row .ri{width:36px;height:36px;border-radius:10px;background:var(--blue-soft);display:flex;align-items:center;justify-content:center;font-size:1.05rem;flex-shrink:0;}
.recent-row .rt{min-width:0;flex:1;}
.recent-row .rt b{display:block;font-size:.88rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
.recent-row .rt span{font-size:.74rem;color:var(--muted);}
.rtime{font-size:.72rem;color:var(--muted);white-space:nowrap;}
.mini-memos{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:12px;}
.mini-memo{background:var(--white);border:1px solid var(--line);border-left:4px solid var(--blue);border-radius:12px;padding:12px 14px;cursor:pointer;transition:transform .15s,box-shadow .15s;}
.mini-memo:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(0,0,0,.08);}
.mini-memo b{display:block;font-size:.9rem;margin-bottom:4px;}
.mini-memo p{margin:0;font-size:.8rem;color:var(--muted);line-height:1.45;word-break:break-word;}
.mini-memo small{display:block;margin-top:8px;font-size:.7rem;color:var(--muted);}
.act-row{display:flex;gap:10px;align-items:baseline;padding:8px 0;border-bottom:1px dashed var(--line);font-size:.82rem;}
.act-row:last-child{border-bottom:none;}
.dash-empty{text-align:center;padding:22px 8px;color:var(--muted);font-size:.84rem;line-height:1.5;}
.fmt-bar .btn:disabled,.memo-toolbar button:disabled{opacity:.38;cursor:not-allowed;}
.hist-btn:disabled,.memo-toolbar .hist-btn:disabled,.fmt-bar .hist-btn:disabled{opacity:.55;cursor:not-allowed;border-color:var(--line);color:var(--muted);}
.fmt-bar .tb-sep,.memo-toolbar .tb-sep{align-self:stretch;}
@media (pointer:coarse){ .hist-btn,.memo-toolbar button,.fmt-bar .btn{min-height:44px;min-width:44px;} }
/* judul/tanggal memo & placeholder selalu ikut warna tema */
input::placeholder,textarea::placeholder{color:var(--muted);opacity:.75;}
#me_title{color:var(--ink);caret-color:var(--blue);}
#me_date{background:var(--white);color:var(--ink);border:1px solid var(--line);border-radius:8px;padding:7px 10px;font-family:inherit;}
.memo-editor-block{color:var(--ink);caret-color:var(--blue);}
.memo-table-wrap{background:var(--white);}
/* kotak edit sel: pas di dalam sel (melebar hanya kalau teksnya lebih panjang), tanpa garis fokus bawaan browser & tanpa bayangan; cincin biru tipis = penanda sel aktif */
table.sheet td input{position:absolute;left:0;top:0;height:100%;width:100%;box-sizing:border-box;border:0;outline:none;border-radius:0;padding:6px 8px;font-size:inherit;font-family:inherit;background:var(--white);color:var(--ink);box-shadow:inset 0 0 0 2px var(--blue);z-index:40;}
table.sheet td input:focus,table.sheet td input:focus-visible{outline:none;}
.sheet-card-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;margin-bottom:20px;}

/* ===== Toolbar Tabel & Memo (gaya Google Sheets / Docs, ikut tema) ===== */
.rtb{display:flex;flex-wrap:wrap;gap:3px;align-items:center;padding:6px 8px;background:var(--white);border:1px solid var(--line);border-radius:12px;margin:0 0 12px;}
@media(min-width:701px){.rtb.stick{position:sticky;top:var(--tbh,72px);z-index:9;box-shadow:0 4px 10px rgba(0,0,0,.05);}}
.rtb .tb{border:1px solid transparent;background:none;color:var(--ink);min-width:36px;height:36px;padding:0 8px;border-radius:8px;font-size:.84rem;display:inline-flex;align-items:center;justify-content:center;gap:4px;cursor:pointer;flex-shrink:0;font-family:inherit;line-height:1;}
.rtb .tb:hover:not(:disabled){background:var(--blue-soft);}
.rtb .tb.on{background:var(--blue);color:#fff;}
.rtb .tb:disabled{opacity:.38;cursor:not-allowed;}
.rtb .tb svg{display:block;}
.rtb .tb.wide{min-width:104px;justify-content:space-between;}
.rtb .tb.wide span:first-child{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:92px;}
.rtb .tb-color{flex-direction:column;gap:2px;}
.rtb .tb-color .bar{display:block;height:3px;width:16px;border-radius:2px;border:1px solid var(--line);}
.rtb .tb-sep{display:block;width:1px;height:22px;background:var(--line);margin:0 3px;flex-shrink:0;}
.rtb .tb-size{display:inline-flex;align-items:center;flex-shrink:0;}
.rtb .tb-size .tb{min-width:30px;padding:0 6px;}
.rtb .tb-size .tb.num{min-width:42px;border:1px solid var(--line);}
.rtb .tb-more{display:none;}
.rtb .fmt-info{margin-left:6px;font-size:.74rem;color:var(--muted);white-space:nowrap;}
@media(max-width:700px){
  .rtb .tb-x{display:none !important;}
  .rtb.tb-open .tb-x{display:inline-flex !important;}
  .rtb.tb-open .tb-sep.tb-x{display:block !important;}
  .rtb .tb-more{display:inline-flex;}
  .rtb .fmt-info{display:none;}
}
@media(max-width:700px){.rtb .tb{min-width:40px;height:40px;}.rtb .tb-size .tb{min-width:36px;}}
@media (pointer:coarse){.rtb .tb{min-width:42px;height:42px;}.rtb .tb.wide{min-width:104px;}.rtb .tb-size .tb{min-width:34px;}}
.tb-pop{position:fixed;z-index:150;background:var(--white);border:1px solid var(--line);border-radius:12px;box-shadow:0 12px 32px rgba(0,0,0,.22);padding:6px;max-height:60vh;overflow:auto;color:var(--ink);}
.tb-pop .it{display:flex;align-items:center;gap:8px;width:100%;text-align:left;padding:9px 12px;background:none;border:none;border-radius:8px;color:var(--ink);font-size:.86rem;cursor:pointer;white-space:nowrap;}
.tb-pop .it:hover,.tb-pop .it.sel{background:var(--blue-soft);}
.tb-pal{display:grid;grid-template-columns:repeat(8,26px);gap:5px;padding:4px;}
.tb-pal button{width:26px;height:26px;border-radius:6px;border:1px solid rgba(0,0,0,.2);cursor:pointer;padding:0;}
.tb-pal button:hover{outline:2px solid var(--blue);outline-offset:1px;}
/* isi memo: judul, subjudul, daftar */
.memo-editor-block h1,.memo-item .mc h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.7em;font-weight:800;line-height:1.25;margin:.2em 0 .35em;}
.memo-editor-block h2,.memo-item .mc h2{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.3em;font-weight:700;line-height:1.3;margin:.2em 0 .3em;}
.memo-editor-block ul,.memo-editor-block ol,.memo-item .mc ul,.memo-item .mc ol{margin:0 0 10px;padding-left:26px;}
.memo-table-wrap .cellval{color:var(--ink);}

.fbtn{margin-left:4px;border:1px solid var(--line);background:var(--white);color:var(--muted);border-radius:6px;font-size:.68rem;padding:0 6px;cursor:pointer;line-height:18px;vertical-align:middle;}
.fbtn:hover{background:var(--blue-soft);}
.fbtn.on{background:var(--blue);color:#fff;border-color:var(--blue);}
.flt-banner{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin:0 0 10px;padding:8px 12px;border-radius:10px;background:var(--blue-soft);color:var(--blue-d);font-size:.8rem;font-weight:600;}
.tb-pop select,.tb-pop input[type=text]{width:100%;padding:8px 10px;border-radius:8px;border:1px solid var(--line);background:var(--bg);color:var(--ink);font-size:.86rem;font-family:inherit;margin-top:4px;}
.tb-pop label.lbl{display:block;font-size:.74rem;font-weight:700;color:var(--muted);margin-top:8px;}
.tb-pop .fl-row{display:flex;align-items:center;gap:8px;padding:5px 4px;font-size:.84rem;cursor:pointer;}

/* ===== Editor Memo: satu halaman menyatu (tanpa kotak pemisah antar teks, tabel, checklist) ===== */
#me_blocks{min-height:45vh;padding:4px 0 24px;}
#me_blocks .memo-editor-block{min-height:0;padding:2px 0;margin:0 0 6px;background:none;border:none;border-radius:0;font-size:1rem;line-height:1.75;outline:none;}
#me_blocks .memo-editor-block:focus{outline:none;}
#me_blocks .memo-editor-block:last-child{min-height:30vh;}
#me_blocks .memo-editor-block p{margin:0 0 8px;}
#me_blocks .memo-table-wrap{margin:8px 0 10px;border:none;border-radius:0;background:none;}
#me_blocks .memo-table-wrap table.memo-table{border:1px solid var(--line);background:var(--white);}
#me_blocks .table-block-actions{background:none;padding:8px 0 0;opacity:0;transition:opacity .15s;}
#me_blocks .memo-table-wrap:hover .table-block-actions,#me_blocks .memo-table-wrap:focus-within .table-block-actions{opacity:1;}
@media(hover:none){#me_blocks .table-block-actions{opacity:1;}}
#me_blocks .memo-checklist{background:none;border:none;border-radius:0;padding:0;margin:4px 0 10px;}
#me_blocks .chk-row{gap:12px;margin-bottom:4px;}
#me_blocks .chk-row input[type="checkbox"]{width:20px;height:20px;accent-color:var(--blue);}
#me_blocks .chk-text{border-bottom:none;font-size:1rem;padding:6px 2px;font-family:inherit;}
#me_blocks .chk-del{opacity:0;}
#me_blocks .chk-row:hover .chk-del,#me_blocks .chk-row:focus-within .chk-del{opacity:1;}
@media(hover:none){#me_blocks .chk-del{opacity:.6;}}
#me_blocks .memo-checklist>.btn{border:none;background:none;box-shadow:none;color:var(--muted);padding:4px 2px;}
#me_blocks .memo-checklist>.btn:hover{color:var(--blue);background:none;}

/* ===== Memo: teks pas di garis latar, footer di dasar layar, foto ===== */
#me_blocks{background:var(--bg);padding-bottom:104px;}
#me_blocks .memo-editor-block,#me_blocks .memo-checklist,#me_blocks .memo-checklist .chk-row{
  background-image:repeating-linear-gradient(to bottom,transparent 0 25px,var(--rule) 25px 26px,transparent 26px 32px);}
#me_blocks .memo-editor-block{line-height:32px;padding:0;margin:0;font-size:1rem;}
#me_blocks .memo-editor-block:last-child{min-height:320px;}
#me_blocks .memo-editor-block p{margin:0;}
#me_blocks .memo-editor-block ul,#me_blocks .memo-editor-block ol{margin:0;padding-left:26px;}
#me_blocks .memo-editor-block h1{font-size:1.55em;line-height:32px;margin:0;}
#me_blocks .memo-editor-block h2{font-size:1.25em;line-height:32px;margin:0;}
#me_blocks .memo-checklist{margin:0;padding:0;background-image:none;}
#me_blocks .chk-row{height:32px;margin:0;gap:12px;}
#me_blocks .chk-row input[type="checkbox"]{width:18px;height:18px;}
#me_blocks .chk-text{height:32px;padding:0 2px;line-height:32px;font-size:1rem;}
#me_blocks .memo-checklist>.btn{height:32px;padding:0 2px;line-height:32px;}
#me_blocks .memo-table-wrap{margin:10px 0;}
.memo-footer{position:fixed;left:250px;right:0;bottom:0;z-index:25;background:var(--bg);border-top:1px solid var(--line);padding:10px 22px calc(10px + env(safe-area-inset-bottom,0px));}
.memo-footer .mf-in{display:flex;align-items:center;gap:8px;max-width:936px;}
.memo-footer .save-status{margin-right:auto;}
@media(max-width:820px),(max-height:500px) and (max-width:1000px){.memo-footer{left:0;padding:10px 16px calc(10px + env(safe-area-inset-bottom,0px));}}
#me_blocks{display:flow-root;}
#me_blocks .memo-img-wrap{position:relative;margin:10px 0;line-height:0;max-width:100%;}
#me_blocks .memo-img-wrap.lay-c{margin-left:auto;margin-right:auto;}
#me_blocks .memo-img-wrap.lay-r{margin-left:auto;}
#me_blocks .memo-img-wrap.lay-wl{float:left;margin:4px 16px 8px 0;}
#me_blocks .memo-img-wrap.lay-wr{float:right;margin:4px 0 8px 16px;}
#me_blocks .memo-table-wrap,#me_blocks .memo-checklist,#me_blocks .memo-editor-block.clr{clear:both;}
/* Daftar berpoin/bernomor di samping foto: jadikan kotak sendiri (BFC) supaya titik/nomor ikut bergeser ke kanan foto, tidak menempel/tertimpa foto */
#me_blocks .memo-editor-block ul,#me_blocks .memo-editor-block ol,.memo-item .mc ul,.memo-item .mc ol{overflow:hidden;padding-left:30px;}
#me_blocks .memo-editor-block li,.memo-item .mc li{padding-left:2px;}
#me_blocks .memo-editor-block.gap0{height:0 !important;min-height:0 !important;overflow:hidden;margin:0;padding:0;background:none !important;}
.memo-item .mc.clr{clear:both;}
.img-actions{flex-wrap:wrap;justify-content:flex-end;max-width:calc(100% - 16px);}
.img-actions .img-row2{display:flex;gap:4px;flex-basis:100%;justify-content:flex-end;}
.memo-item.open .mbody{display:flow-root;}
/* Pratinjau memo yang dibuka dibatasi tingginya; tombol "Tampilkan semua" membukanya penuh */
.memo-item .mbody.clamp{max-height:230px;overflow:hidden;-webkit-mask-image:linear-gradient(#000 72%,transparent);mask-image:linear-gradient(#000 72%,transparent);}
.memo-item .mbody.clamp .imgblk{max-height:190px;overflow:hidden;}
.memo-item .actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
.memo-item .mtime{margin-left:auto;font-size:.78rem;color:var(--muted);font-variant-numeric:tabular-nums;white-space:nowrap;}
.memo-item .imgph{display:flex;align-items:center;justify-content:center;min-height:90px;background:var(--bg);border:1px dashed var(--line);border-radius:10px;color:var(--muted);font-size:.8rem;}
.hist-bar{display:flex;align-items:center;justify-content:space-between;gap:10px;margin:8px 0 4px;color:var(--muted);font-size:.82rem;}
.hist-del{margin-left:8px;padding:4px 9px;}
.memo-item .mmore{display:none;border:none;background:none;color:var(--blue);font:inherit;font-size:.82rem;font-weight:600;cursor:pointer;padding:6px 0 0;}
.memo-item.open .mmore.show{display:block;}
.memo-item .mc.imgblk img.memo-photo{width:100%;margin:0;}
.memo-item .mc.imgblk.lay-c{margin-left:auto;margin-right:auto;}
.memo-item .mc.imgblk.lay-r{margin-left:auto;}
.memo-item .mc.imgblk.lay-wl{float:left;margin:4px 14px 6px 0;}
.memo-item .mc.imgblk.lay-wr{float:right;margin:4px 0 6px 14px;}
#me_blocks .memo-img-wrap img{display:block;width:100%;height:auto;border-radius:10px;}
#me_blocks .memo-img-wrap .img-actions{position:absolute;top:8px;right:8px;display:flex;gap:4px;opacity:0;transition:opacity .15s;line-height:1;}
#me_blocks .memo-img-wrap:hover .img-actions,#me_blocks .memo-img-wrap:focus-within .img-actions{opacity:1;}
@media(hover:none){#me_blocks .memo-img-wrap .img-actions{opacity:1;}}
.img-actions button{border:none;background:rgba(15,23,42,.72);color:#fff;border-radius:8px;padding:7px 10px;font-size:.74rem;cursor:pointer;font-family:inherit;min-height:32px;}
.img-actions button.on{background:var(--blue);}
.img-actions button.del{background:var(--danger);}
.memo-item .mc img.memo-photo{display:block;max-width:100%;height:auto;border-radius:10px;margin:6px 0;}

/* foto di tabel */
.sh-photos{margin-top:16px;}
.sh-photos h4{margin:0 0 8px;font-size:.85rem;color:var(--muted);font-weight:600;}
.sh-ph-list{display:flex;flex-wrap:wrap;gap:12px;align-items:flex-start;}
.sh-ph{position:relative;margin:0;max-width:100%;}
.sh-ph img{display:block;width:100%;height:auto;border-radius:10px;border:1px solid var(--rule);}
.sh-ph .img-actions{position:absolute;top:8px;right:8px;display:flex;gap:4px;opacity:0;transition:opacity .15s;line-height:1;}
.sh-ph:hover .img-actions,.sh-ph:focus-within .img-actions{opacity:1;}
@media(hover:none){.sh-ph .img-actions{opacity:1;}}
/* theme picker */
.theme-btn{background:none;border:1px solid var(--line);width:36px;height:36px;border-radius:10px;font-size:1rem;display:flex;align-items:center;justify-content:center;color:var(--ink);flex-shrink:0;}
.theme-btn:hover{background:var(--blue-soft);}
.theme-pop{position:fixed;z-index:120;background:var(--white);border:1px solid var(--line);border-radius:14px;box-shadow:0 12px 32px rgba(0,0,0,.18);padding:12px;width:220px;}
.theme-pop h5{margin:0 0 8px;font-size:.82rem;color:var(--blue);font-weight:700;}
.theme-opt{display:flex;align-items:center;gap:10px;padding:8px 8px;border-radius:9px;font-size:.86rem;font-weight:500;}
.theme-opt:hover{background:var(--blue-soft);cursor:pointer;}
.theme-opt.sel{background:var(--blue-soft);font-weight:700;}
.swatch{width:20px;height:20px;border-radius:50%;border:1px solid rgba(0,0,0,.1);flex-shrink:0;}

/* photo */
.pcard{padding:0 0 15px;overflow:hidden;}
.pcard .pbody{padding:15px 16px 0;}
.pcard .pphoto{width:100%;height:120px;object-fit:cover;display:block;background:var(--bg);}
.photo-input-wrap{border:1.5px dashed var(--line);border-radius:10px;padding:10px;text-align:center;position:relative;}
.photo-preview{max-width:100%;max-height:140px;border-radius:9px;display:block;margin:0 auto 8px;}
.photo-actions{display:flex;justify-content:center;gap:8px;}

@media(max-width:820px),(max-height:500px) and (max-width:1000px){
  .side{position:fixed;left:-260px;transition:left .2s;z-index:60;box-shadow:6px 0 20px rgba(0,0,0,.2);}
  .side.open{left:0;}
  .burger{display:block;}
  .content{padding:16px;}
  .field-row{flex-direction:column;gap:0;}
  .storage-ind span.txt{display:none;}
  .side-backdrop.show{display:block;}
}
.side{padding-left:calc(14px + env(safe-area-inset-left,0px));}
html{-webkit-text-size-adjust:100%;text-size-adjust:100%;}
button,.tb,.folder-item,[role=button]{-webkit-tap-highlight-color:transparent;touch-action:manipulation;}
@media(max-width:820px){
  /* iPhone Safari memperbesar halaman otomatis jika font input < 16px */
  input,select,textarea,.cellval[contenteditable],.memo-editor-block,.chk-text{font-size:16px;}
  .memo-editor-block{font-size:16px;}
  .btn,.folder-item{min-height:40px;}
  .modal{max-width:calc(100vw - 24px);}
}
@media(max-width:360px){.content{padding:12px;}.rtb .tb{min-width:36px;}}
@media(max-height:500px){.rtb.stick{position:static !important;}}
@media(max-height:480px) and (orientation:landscape){.dash-hero{padding:14px 20px;}.memo-footer{padding-top:6px;padding-bottom:calc(6px + env(safe-area-inset-bottom,0px));}}
.side-backdrop{display:none;position:fixed;inset:0;background:rgba(15,23,42,.4);z-index:55;}
</style>
</head>
<body>
<div class="app">
  <nav class="side" id="side">
    <div class="brand">📓 Catatin</div>
    <div id="lastOpenedBox"></div>
    <h4>Folder Saya</h4>
    <div id="folderList"></div>
    <button class="add-folder-btn" id="btnAddFolder">＋ Buat Folder</button>
    <div class="side-nav">
      <div class="folder-item" id="navMemo">📝 Memo</div>
      <div class="folder-item" id="navSheets">📊 Tabel</div>
      <div class="folder-item" id="navHistory">🕒 Riwayat</div>
      <div class="folder-item" id="navDashboard">🏠 Dashboard</div>
    </div>
    <div id="userBox"></div>
  </nav>
  <div class="side-backdrop" id="sideBackdrop"></div>
  <div class="main">
    <div class="topbar">
      <button class="burger" id="burger">☰</button>
      <div class="search-box"><span class="ic">🔍</span><input id="globalSearch" placeholder="Cari barang atau folder..."></div>
      <div class="storage-ind" id="storageInd"></div>
      <button class="theme-btn" id="themeBtn" title="Ganti tema">🎨</button>
    </div>
    <div class="content" id="content"></div>
  </div>
</div>
<button class="fab" id="fabAdd" style="display:none;">＋</button>
<div class="toast" id="toast"></div>

<script defer src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
<script>
/* ---------------- Penyimpanan: API Laravel (MySQL) ----------------
   Aplikasi tetap memanggil all / get / put / del seperti dulu; keempatnya kini berbicara ke server.
   Data di database memakai snake_case (box_qty), aplikasi memakai camelCase (boxQty): diterjemahkan di sini. */
const API = '/api';
const objOf = v => (v && typeof v === 'object' && !Array.isArray(v)) ? v : {};   // PHP mengubah {} kosong menjadi []
const tms = (iso, id) => iso ? Date.parse(String(iso).replace(/\.\d+Z$/, 'Z')) + (id || 0) : 0;   // + id: urutan stabil saat waktunya sama
const toIso = ms => ms ? new Date(ms).toISOString() : null;
const intOrNull = v => { const d = String(v ?? '').replace(/\D/g, ''); return d === '' ? null : parseInt(d, 10); };
const photoCache = new Map();   // foto barang yang sudah diambil (id -> data URL); daftar barang dari server tidak membawa foto
const MAP = {
  folders: {
    path: 'db/folders',
    from: r => ({id:r.id, name:r.name, createdAt:tms(r.created_at, r.id), lastOpenedAt:tms(r.last_opened_at)}),
    to: o => ({name:o.name, last_opened_at:toIso(o.lastOpenedAt), client_uid:o.uid || null}),
  },
  products: {
    path: 'db/products',
    from: r => ({id:r.id, folderId:r.folder_id, date:r.date, name:r.name, price:r.price, boxQty:r.box_qty, smallBoxQty:r.small_box_qty,
                 sellingPrice:r.selling_price, photo:(r.photo ? (photoCache.set(r.id, r.photo), r.photo) : photoCache.get(r.id)) || undefined, hasPhoto:!!(r.has_photo || r.photo), createdAt:tms(r.created_at, r.id), updatedAt:tms(r.updated_at)}),
    to: o => ({folder_id:o.folderId, date:o.date, name:o.name, price:Number(o.price) || 0, box_qty:intOrNull(o.boxQty),
               small_box_qty:intOrNull(o.smallBoxQty), selling_price:Number(o.sellingPrice) || 0, photo:o.photo || null, client_uid:o.uid || null}),
  },
  memos: {
    path: 'db/memos',
    from: r => { const m = {id:r.id, title:r.title || '', date:r.date, blocks:r.blocks || [], createdAt:tms(r.created_at, r.id), updatedAt:tms(r.updated_at)}; if(r.from_sheet) m.fromSheet = r.from_sheet; return m; },
    to: o => ({title:o.title || '', date:o.date, blocks:o.blocks || [], from_sheet:o.fromSheet || null, client_uid:o.uid || null}),
  },
  sheets: {
    path: 'db/sheets',
    from: r => { const s = {id:r.id, name:r.name, rows:r.rows, cols:r.cols, createdAt:tms(r.created_at, r.id), updatedAt:tms(r.updated_at)};
      if('cells' in r){ s.cells = objOf(r.cells); s.fmt = objOf(r.fmt); s.imgs = objOf(r.imgs); if(r.filter && !Array.isArray(r.filter)) s.filter = r.filter; }
      return s; },
    to: (o, withImgs = true) => { const d = {name:o.name, rows:o.rows, cols:o.cols, cells:o.cells || {}, fmt:o.fmt || {}, filter:o.filter || null, client_uid:o.uid || null}; if(withImgs) d.imgs = o.imgs || {}; return d; },   // foto besar: dikirim hanya bila berubah
  },
  activity: {
    path: 'activities',
    from: r => ({id:r.id, type:r.type, entity:r.entity, entityName:r.entity_name, snapshot:r.snapshot || (r.has_snapshot ? {} : null), undone:!!r.undone, ts:tms(r.created_at, r.id)}),
  },
};
const xsrf = () => { const m = document.cookie.match(/(?:^|;\s*)XSRF-TOKEN=([^;]+)/); return m ? decodeURIComponent(m[1]) : ''; };
async function api(path, opt = {}){
  const res = await fetch(API + '/' + path, {credentials:'same-origin', headers:{'Accept':'application/json', 'Content-Type':'application/json', 'X-Requested-With':'XMLHttpRequest', 'X-XSRF-TOKEN':xsrf()}, ...opt});
  if(res.status === 401 || res.status === 419){ location.href = '/masuk'; throw new Error('Sesi berakhir, silakan masuk lagi'); }   // belum login / sesi habis
  if(!res.ok){
    let msg = 'Server error (' + res.status + ')';
    try{ const j = await res.json(); if(j.message) msg = j.message; }catch(e){}
    const err = new Error(msg); err.status = res.status;
    if(res.status === 422) toast(msg, 4500);       // pesan dari validasi / trigger database
    throw err;
  }
  return res.json();
}
// Cache bacaan 20 detik: berpindah halaman tidak lagi mengambil ulang semua data dari server.
// Setiap simpan/hapus langsung membuang cache yang terkait, jadi data selalu segar setelah ada perubahan.
const rawCache = {};
let bustVer = 0;
const bust = (...stores) => { bustVer++; stores.forEach(k => { delete rawCache[k]; }); };
// SATU permintaan untuk semua daftar (db/bundle). `php artisan serve` melayani satu permintaan sekali waktu dan tiap permintaan
// memuat ulang Laravel, jadi 5 permintaan terpisah per halaman = 5x tunggu. Bila server belum punya rute bundle (404), kembali ke cara lama.
let bundleP = null, bundleOk = true;
function fetchBundle(){
  if(bundleP) return bundleP;
  const ver = bustVer;
  const p = api('db/bundle').then(b => {
    if(ver === bustVer){ const t = Date.now(); ['folders','products','memos','sheets','activity'].forEach(k => { rawCache[k] = {t, p:Promise.resolve(b[k] || [])}; }); }   // ada simpan/hapus selama mengunduh: jangan pasang data lama
    return b;
  });
  bundleP = p; const done = () => { if(bundleP === p) bundleP = null; }; p.then(done, done);
  return p;
}
async function all(store){
  const m = MAP[store]; let c = rawCache[store];
  if(!c && bundleOk){
    for(let i = 0; i < 2 && !c; i++){
      try{ await fetchBundle(); }catch(e){ if(e.status === 404 || e.status === 405){ bundleOk = false; break; } throw e; }
      c = rawCache[store];
    }
  }
  if(!c){                                   // cara lama: satu permintaan per jenis data
    const p = api(m.path); const entry = {t:Date.now(), p};
    p.catch(() => { if(rawCache[store] === entry) delete rawCache[store]; });
    rawCache[store] = entry; c = entry;
  } else if(Date.now() - c.t > 45000){
    // Ada data lama? Pakai dulu (layar tidak menunggu server yang sedang sibuk); versi baru diambil di belakang layar untuk tampilan berikutnya.
    c.t = Date.now();
    if(bundleOk) fetchBundle().catch(() => {});
    else { const p = api(m.path); p.then(() => { if(rawCache[store] === c) rawCache[store] = {t:Date.now(), p}; }).catch(() => {}); }
  }
  const rows = (await c.p).map(r => m.from(structuredClone(r)));   // salinan: pemanggil boleh mengubah isinya
  if(store === 'sheets') rows.forEach(r => { const l = shLocal.get(r.id); if(l){ r.name = l.name; r.rows = l.rows; r.cols = l.cols; r.updatedAt = l.updatedAt || r.updatedAt; } });   // nama/ukuran terbaru yang belum sampai server
  return rows;
}
// Foto barang satu folder diambil SETELAH halaman folder tampil (daftar barang sengaja tanpa foto supaya ringan).
async function loadFolderPhotos(fid){
  const imgs = [...document.querySelectorAll('img[data-lazyphoto]')]; if(!imgs.length) return;
  try{
    const map = await api('db/products-photos/' + fid);
    Object.keys(map).forEach(id => photoCache.set(Number(id), map[id]));
    imgs.forEach(im => { const src = photoCache.get(Number(im.dataset.lazyphoto)); if(src && im.isConnected){ im.src = src; im.removeAttribute('data-lazyphoto'); im.style.minHeight = ''; } });
  }catch(e){}
}
/* Tabel disimpan "lokal dulu": ketikan langsung tercatat di memori (instan, seperti dulu), lalu dikirim ke server
   di belakang layar ~0,7 detik setelah berhenti mengetik. Tanpa ini, tiap ketikan menunggu server dan layar terasa macet. */
const shLocal = new Map();      // id tabel -> data terbaru (format aplikasi)
// Salin tabel TANPA menggandakan foto (data foto bisa beberapa MB; isinya tidak pernah diubah, cukup dipakai bersama)
function cloneSheet(o){ const {imgs, ...rest} = o; const c = structuredClone(rest); c.imgs = imgs || {}; return c; }
const shDirty = new Set();      // id tabel yang belum terkirim ke server
let shTimer = null, shFlight = Promise.resolve();
// Bila ada foto baru yang belum terkirim, tunda lebih lama (3 dtk) supaya unggahan besar tidak bertabrakan dengan ketikan berikutnya.
function shSchedule(id){ shDirty.add(id); clearTimeout(shTimer); const o = shLocal.get(id); shTimer = setTimeout(shFlush, (o && shSent.get(id) !== imgSig(o)) ? 3000 : 1200); }
function shFlush(){
  clearTimeout(shTimer);
  shFlight = shFlight.then(async () => {
    for(const id of [...shDirty]){
      shDirty.delete(id);
      const o = shLocal.get(id); if(!o) continue;
      try{ await serverPut('sheets', o); }   // simpan isi tabel tidak mengubah daftar/riwayat, jadi cache tidak dibuang (halaman lain tetap instan)
      
      catch(e){ shDirty.add(id); toast('Gagal menyimpan tabel ke server, mencoba lagi…', 3000); clearTimeout(shTimer); shTimer = setTimeout(shFlush, 3000); }
    }
  });
  return shFlight;
}
// Jangan kehilangan ketikan terakhir saat tab ditutup / pindah
addEventListener('pagehide', () => {
  for(const id of shDirty){ const o = shLocal.get(id); if(o) try{ fetch(API + '/db/sheets/' + id, {method:'PUT', keepalive:true, headers:{'Content-Type':'application/json','Accept':'application/json'}, body:JSON.stringify({payload:JSON.stringify(MAP.sheets.to(o))})}); }catch(e){} }
});
document.addEventListener('visibilitychange', () => { if(document.visibilityState === 'hidden' && shDirty.size) shFlush(); });

async function get(store, id){
  if(store === 'sheets' && shLocal.has(id)) return cloneSheet(shLocal.get(id));
  try{
    const o = MAP[store].from(await api(MAP[store].path + '/' + id));
    if(store === 'sheets'){ shSent.set(id, imgSig(o)); shLocal.set(id, cloneSheet(o)); }
    return o;
  }catch(e){ if(e.status === 404) return undefined; throw e; }
}
const imgSig = o => Object.keys(o.imgs || {}).sort().join(',');     // foto tidak pernah diubah isinya, jadi cukup bandingkan daftar id
const shSent = new Map();                                            // id tabel -> daftar foto yang sudah ada di server
async function serverPut(store, obj){
  const withImgs = store !== 'sheets' || shSent.get(obj.id) !== imgSig(obj);
  const m = MAP[store], body = JSON.stringify({payload: JSON.stringify(m.to(obj, withImgs))});
  if(obj.id != null){
    const saved = await api(m.path + '/' + obj.id, {method:'PUT', body});
    if(store === 'sheets') shSent.set(saved.id, imgSig(obj));
    return saved.id;
  }
  // Data BARU: bila permintaan yang SAMA persis masih berjalan (klik dua kali / simpan ganda), pakai jawaban yang sama, jangan kirim lagi.
  const k = store + '|' + body;
  if(createFlight.has(k)) return createFlight.get(k);
  const p = (async () => {
    const saved = await api(m.path, {method:'POST', body});
    if(store === 'sheets') shSent.set(saved.id, imgSig(obj));
    return saved.id;
  })();
  createFlight.set(k, p);
  const free = () => createFlight.delete(k); p.then(free, free);
  return p;
}
const createFlight = new Map();
// "Terakhir dibuka": simpan ke server TANPA membuang cache daftar folder (cache diperbarui di tempat), jadi membuka folder tidak memicu unduh ulang data.
async function markFolderOpened(f){
  await serverPut('folders', f);
  const c = rawCache.folders, iso = new Date(f.lastOpenedAt).toISOString();
  if(c) c.p = c.p.then(rows => rows.map(r => r.id === f.id ? {...r, last_opened_at: iso} : r));
}
async function clearAllActivity(){ await api('activities', {method:'DELETE'}); bust('activity'); }
async function put(store, obj){
  if(store === 'activity') return obj.id || 0;     // riwayat ditulis otomatis oleh TRIGGER di database
  if(store === 'sheets'){
    if(obj.id == null){ const id = await serverPut('sheets', obj); shLocal.set(id, cloneSheet({...obj, id})); bust('sheets', 'activity'); return id; }   // tabel baru: butuh id dari server
    shLocal.set(obj.id, cloneSheet(obj)); shSchedule(obj.id); return obj.id;
  }
  const id = await serverPut(store, obj);
  bust(store, 'activity');
  return id;
}
async function del(store, id){
  if(store === 'sheets'){ shDirty.delete(id); shLocal.delete(id); }
  await api(MAP[store].path + '/' + id, {method:'DELETE'}); bust(store, 'activity'); if(store === 'folders') bust('products');
}
// Nama pengguna + tombol Keluar di sidebar
(async () => {
  try{
    const me = await api('me'), box = document.getElementById('userBox');
    if(!box) return;
    const nm = String(me.name || me.email || '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    box.innerHTML = '<div class="user-box"><span class="user-name" title="' + nm + '">👤 ' + nm + '</span><button class="btn small ghost" id="btnLogout">Keluar</button></div>';
    document.getElementById('btnLogout').onclick = async () => {
      try{ await fetch('/keluar', {method:'POST', credentials:'same-origin', headers:{'Accept':'application/json', 'X-XSRF-TOKEN':xsrf()}}); }catch(e){}
      location.href = '/masuk';
    };
  }catch(e){}
})();
const openDB = async () => {};            // tidak perlu membuka database lokal
async function seedIfEmpty(){}            // data contoh dibuat oleh `php artisan db:seed`

/* ---------------- helpers ---------------- */
const rupiah = n => 'Rp' + Number(n||0).toLocaleString('id-ID');
// Tanggal HARI INI menurut jam perangkat (toISOString memakai UTC, sehingga dini hari di Indonesia terbaca sebagai kemarin).
const todayISO = () => { const d = new Date(), z = n => String(n).padStart(2, '0'); return d.getFullYear() + '-' + z(d.getMonth() + 1) + '-' + z(d.getDate()); };
// 'YYYY-MM-DD' dibaca sebagai tanggal lokal (bukan UTC) supaya tidak bergeser sehari di zona waktu mana pun.
const fmtDate = s => { if(!s) return '-'; const m = /^(\d{4})-(\d{2})-(\d{2})$/.exec(String(s)); const d = m ? new Date(+m[1], +m[2]-1, +m[3]) : new Date(s); return isNaN(d)?s:d.toLocaleDateString('id-ID',{day:'2-digit',month:'short',year:'numeric'}); };
function esc(s){ return (s||'').toString().replace(/[&<>"']/g, c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }
let toastTimer;
function toast(m, ms=2200){ const t=document.getElementById('toast'); t.textContent=m; t.classList.add('show'); clearTimeout(toastTimer); toastTimer=setTimeout(()=>t.classList.remove('show'), ms); }
// Isi Dus: hanya angka (data lama yang terlanjur berisi teks seperti "12 pcs" tetap tampil sebagai 12)
function boxDisplay(v){ const d = String(v ?? '').replace(/\D/g,''); return d || '-'; }

/* ---------------- Toolkit: angka Indonesia, popover toolbar, ikon ---------------- */
// Mengubah teks sel jadi angka. Mengerti "1.500.000", "Rp1.500.000", "1500,5". Titik tunggal ("1.500") dianggap
// pemisah ribuan hanya pada sel berformat Rupiah (rpCtx); selain itu dianggap desimal ("1.5").
function toNum(v, rpCtx){
  if(typeof v === 'number') return v;
  let s = String(v == null ? '' : v).trim().replace(/^(-?)\s*Rp\.?\s*/i, '$1').replace(/\s+/g, '');
  if(s === '') return NaN;
  if(/^-?\d{1,3}(\.\d{3}){2,}(,\d+)?$/.test(s) || (rpCtx && /^-?\d{1,3}\.\d{3}(,\d+)?$/.test(s))) return Number(s.replace(/\./g, '').replace(',', '.'));
  if(/^-?\d+,\d+$/.test(s)) return Number(s.replace(',', '.'));
  if(/^-?(\d+\.?\d*|\.\d+)(e[+-]?\d+)?$/i.test(s)) return Number(s);
  return NaN;
}
function fmtNum(n, dec){
  const neg = n < 0; const s = Math.abs(n).toFixed(Math.max(0, Math.min(10, dec)));
  let [i, d] = s.split('.'); i = i.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  return (neg ? '-' : '') + i + (d ? ',' + d : '');
}
function natDec(n){ const s = String(+Number(n).toFixed(10)); const p = s.indexOf('.'); return p < 0 ? 0 : s.length - p - 1; }
// Format tampilan sel. Rupiah: titik = ribuan, koma = desimal (1500000 -> Rp1.500.000). Teks biasa tidak diubah.
function applyNumFmt(disp, f){
  if(!f || (!f.nf && f.dec == null)) return disp;
  if(disp === '' || disp == null) return disp;
  const n = toNum(disp, f.nf === 'rupiah'); if(!isFinite(n)) return disp;
  if(!f.nf) return n.toFixed(Math.min(10, f.dec)).replace('.', ',');
  if(f.nf === 'rupiah'){ const t = fmtNum(n, f.dec == null ? 0 : f.dec); return t[0] === '-' ? '-Rp' + t.slice(1) : 'Rp' + t; }
  if(f.nf === 'percent') return fmtNum(n * 100, f.dec == null ? 0 : f.dec) + '%';
  return fmtNum(n, f.dec == null ? natDec(n) : f.dec);
}
const FONTS = ['Inter','Plus Jakarta Sans','Arial','Georgia','Times New Roman','Courier New','Verdana','Trebuchet MS','Comic Sans MS','JetBrains Mono'];
const FONT_SIZES = [8,9,10,11,12,13,14,16,18,20,24,28,36];
const PALETTE = ['#000000','#434343','#666666','#999999','#b7b7b7','#d9d9d9','#efefef','#ffffff',
  '#dc2626','#f97316','#facc15','#16a34a','#06b6d4','#3b82f6','#8b5cf6','#ec4899',
  '#fecaca','#fed7aa','#fef08a','#bbf7d0','#a5f3fc','#bfdbfe','#ddd6fe','#fbcfe8',
  '#f87171','#fb923c','#fde047','#4ade80','#22d3ee','#60a5fa','#a78bfa','#f472b6',
  '#991b1b','#9a3412','#854d0e','#166534','#155e75','#1e40af','#5b21b6','#9d174d'];
const safeColor = c => (typeof c === 'string' && /^#[0-9a-f]{3,8}$/i.test(c)) ? c : '';
const safeFont = f => FONTS.includes(f) ? f : '';
const tbOpen = {sheet:false, memo:false};   // toolbar HP: apakah menu tambahan (⋯) sedang dibuka

function closePops(){ document.querySelectorAll('.tb-pop').forEach(p=>p.remove()); }
function openPop(anchor, build){
  const had = anchor._pop && document.body.contains(anchor._pop);
  closePops(); if(had){ anchor._pop = null; return; }
  const pop = document.createElement('div'); pop.className = 'tb-pop';
  pop.addEventListener('mousedown', e=>{ if(!/^(INPUT|SELECT|TEXTAREA|OPTION)$/.test(e.target.tagName)) e.preventDefault(); });   // jangan merebut fokus/seleksi dari editor (kecuali kolom isian)
  build(pop); document.body.appendChild(pop); anchor._pop = pop;
  const r = anchor.getBoundingClientRect(), pw = pop.offsetWidth, ph = pop.offsetHeight;
  let left = r.left, top = r.bottom + 6;
  if(left + pw > innerWidth - 8) left = Math.max(8, innerWidth - pw - 8);
  if(top + ph > innerHeight - 8 && r.top - ph - 6 > 8) top = r.top - ph - 6;
  pop.style.left = left + 'px'; pop.style.top = top + 'px';
  setTimeout(()=>document.addEventListener('mousedown', function cl(ev){
    if(!document.body.contains(pop)){ document.removeEventListener('mousedown', cl); return; }
    if(!pop.contains(ev.target) && !anchor.contains(ev.target)){ pop.remove(); document.removeEventListener('mousedown', cl); }
  }), 0);
}
function menuPop(anchor, items, cur, pick){
  openPop(anchor, pop=>items.forEach(it=>{
    const b = document.createElement('button'); b.type = 'button'; b.className = 'it' + (it.v === cur ? ' sel' : '');
    b.innerHTML = it.html || esc(it.label); if(it.style) b.setAttribute('style', it.style);
    b.addEventListener('click', ()=>{ closePops(); pick(it.v); }); pop.appendChild(b);
  }));
}
function colorPop(anchor, pick, resetLabel){
  openPop(anchor, pop=>{
    const g = document.createElement('div'); g.className = 'tb-pal';
    PALETTE.forEach(c=>{ const b = document.createElement('button'); b.type = 'button'; b.style.background = c; b.title = c; b.setAttribute('aria-label', c); b.addEventListener('click', ()=>{ closePops(); pick(c); }); g.appendChild(b); });
    pop.appendChild(g);
    const r = document.createElement('button'); r.type = 'button'; r.className = 'it'; r.textContent = resetLabel || 'Otomatis';
    r.addEventListener('click', ()=>{ closePops(); pick(null); }); pop.appendChild(r);
  });
}
const _svg = (p, w=18) => `<svg viewBox="0 0 24 24" width="${w}" height="${w}" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">${p}</svg>`;
const IC = {
  undo: _svg('<path d="M9 14 4 9l5-5"/><path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5 5.5 5.5 0 0 1-5.5 5.5H11"/>'),
  redo: _svg('<path d="m15 14 5-5-5-5"/><path d="M20 9H9.5A5.5 5.5 0 0 0 4 14.5 5.5 5.5 0 0 0 9.5 20H13"/>'),
  fill: _svg('<path d="m19 11-8-8-8.6 8.6a2 2 0 0 0 0 2.8l5.2 5.2c.8.8 2 .8 2.8 0L19 11Z"/><path d="m5 2 5 5"/><path d="M2 13h15"/><path d="M22 20a2 2 0 1 1-4 0c0-1.6 1.7-2.4 2-4 .3 1.6 2 2.4 2 4Z"/>'),
  border: _svg('<rect x="3" y="3" width="18" height="18" rx="1"/><path d="M3 12h18M12 3v18"/>'),
  table: _svg('<rect x="3" y="4" width="18" height="16" rx="1.5"/><path d="M3 10h18M3 15h18M9 4v16M15 4v16"/>'),
  valign: _svg('<path d="M3 3h18M3 21h18"/><path d="M12 7v10M9 10l3-3 3 3M9 14l3 3 3-3"/>'),
  brush: _svg('<rect x="3" y="3" width="14" height="6" rx="1.5"/><path d="M17 6h3v6H11v3"/><rect x="9" y="15" width="4" height="6" rx="1"/>'),
  bullet: _svg('<path d="M9 6h12M9 12h12M9 18h12"/><circle cx="4" cy="6" r="1.2" fill="currentColor"/><circle cx="4" cy="12" r="1.2" fill="currentColor"/><circle cx="4" cy="18" r="1.2" fill="currentColor"/>'),
  numbered: _svg('<path d="M10 6h11M10 12h11M10 18h11"/><path d="M3.5 4.5 5 4v4M3.5 11h2l-2 2.5h2M3.5 16.5h2l-1 1 1 1h-2" stroke-width="1.4"/>'),
  check: _svg('<path d="m3 6 2 2 3.5-3.5M3 14l2 2 3.5-3.5"/><path d="M13 7h8M13 15h8"/>'),
  alL: _svg('<path d="M4 6h16M4 10h10M4 14h16M4 18h10"/>'),
  alC: _svg('<path d="M4 6h16M7 10h10M4 14h16M7 18h10"/>'),
  alR: _svg('<path d="M4 6h16M10 10h10M4 14h16M10 18h10"/>'),
  filter: _svg('<polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>'),
  image: _svg('<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.1-3.1a2 2 0 0 0-2.8 0L6 21"/>'),
  clear: _svg('<path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3"/>')
};

/* Rupiah input: user types/reads with '.' as thousands separator, never decimal. */
function digitsOnly(s){ return (s||'').replace(/\D/g,''); }
function formatThousands(digits){ return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }
function parseRupiah(s){ const d = digitsOnly(s); return d ? parseInt(d, 10) : 0; }
function attachRupiahInput(el){
  el.setAttribute('inputmode','numeric');
  el.setAttribute('autocomplete','off');
  el.addEventListener('input', ()=>{
    const raw = el.value;
    const cursor = el.selectionStart;
    const digitsBeforeCursor = digitsOnly(raw.slice(0, cursor)).length;
    const formatted = formatThousands(digitsOnly(raw));
    el.value = formatted;
    // restore caret based on digit count so typing never jumps or corrupts the value
    let count = 0, pos = formatted.length;
    for(let i=0;i<formatted.length;i++){
      if(/\d/.test(formatted[i])) count++;
      if(count === digitsBeforeCursor){ pos = i+1; break; }
      if(digitsBeforeCursor === 0){ pos = 0; break; }
    }
    el.setSelectionRange(pos, pos);
  });
}

/* Auto-capitalize: only the freshly-typed first letter of a word, never reformats the rest.
   User is always free to type it back to lowercase afterwards. */
function attachAutoCapitalize(el){
  el.addEventListener('input', e=>{
    if(e.inputType !== 'insertText' || !e.data) return;
    const pos = el.selectionStart;
    const insertStart = pos - e.data.length;
    if(insertStart < 0) return;
    const before = insertStart === 0 ? null : el.value[insertStart-1];
    const isWordStart = insertStart === 0 || before === ' ';
    if(!isWordStart) return;
    const upper = e.data.charAt(0).toUpperCase() + e.data.slice(1);
    if(upper !== e.data){
      el.value = el.value.slice(0, insertStart) + upper + el.value.slice(pos);
      el.setSelectionRange(pos, pos);
    }
  });
}

/* ---------------- storage indicator (sync simulation) ---------------- */
let pendingSync = false;
function renderStorageInd(){
  const el = document.getElementById('storageInd');
  if(!navigator.onLine){ el.innerHTML = '<span class="dot red"></span><span class="txt">Offline</span>'; return; }
  if(pendingSync){ el.innerHTML = '<span class="dot yellow"></span><span class="txt">Belum disinkronkan</span>'; return; }
  el.innerHTML = '<span class="dot green"></span><span class="txt">Tersimpan</span>';
}
window.addEventListener('online', ()=>{ if(pendingSync){ setTimeout(()=>{ pendingSync=false; renderStorageInd(); toast('Data tersinkron ke server'); }, 900); } renderStorageInd(); });
window.addEventListener('offline', renderStorageInd);
function markWrite(){ if(!navigator.onLine) pendingSync = true; renderStorageInd(); }

/* ---------------- state & routing ---------------- */
let view = 'dashboard'; // dashboard | folder | memo | sheets | sheet | history
let activeFolderId = null;
let activeSheetId = null;
let activeMemoId = null;
let searchQuery = '';

document.getElementById('burger').addEventListener('click',()=>{ document.getElementById('side').classList.toggle('open'); syncBackdrop(); });
document.getElementById('sideBackdrop').addEventListener('click', closeSide);
function syncBackdrop(){ document.getElementById('sideBackdrop').classList.toggle('show', document.getElementById('side').classList.contains('open')); }
document.getElementById('navDashboard').addEventListener('click',()=>{ view='dashboard'; activeFolderId=null; closeSide(); render(); });
document.getElementById('navMemo').addEventListener('click',()=>{ view='memo'; closeSide(); render(); });
document.getElementById('navSheets').addEventListener('click',()=>{ view='sheets'; activeSheetId=null; closeSide(); render(); });
document.getElementById('navHistory').addEventListener('click',()=>{ view='history'; closeSide(); render(); });
document.getElementById('btnAddFolder').addEventListener('click', openFolderModal);
function closeSide(){ document.getElementById('side').classList.remove('open'); syncBackdrop(); }

let searchTimer;
document.getElementById('globalSearch').addEventListener('input', e=>{
  clearTimeout(searchTimer);
  searchTimer = setTimeout(()=>{ searchQuery = e.target.value.trim(); render(); }, 150);
});

let lastOpenAt = 0, lastOpenId = null;
async function openFolder(id){
  if(id === lastOpenId && Date.now() - lastOpenAt < 400) return;     // pengaman: klik ganda/pendengar ganda tidak membuka dua kali
  lastOpenId = id; lastOpenAt = Date.now();
  // Folder langsung dibuka; pencatatan "terakhir dibuka" berjalan di latar belakang, jadi tidak ikut macet bila server sedang sibuk menyimpan.
  activeFolderId = id; view='folder'; closeSide(); render();
  (async()=>{
    try{
      const f = (await all('folders')).find(x=>x.id === id); if(!f) return;
      f.lastOpenedAt = Date.now(); if(typeof markFolderOpened === 'function') await markFolderOpened(f); else await put('folders', f); renderSidebar();
    }catch(e){}
  })();
}

/* ---------------- sidebar render ---------------- */
async function renderSidebar(){
  const folders = (await all('folders')).sort((a,b)=>b.createdAt-a.createdAt);
  const last = folders.filter(f=>f.lastOpenedAt).sort((a,b)=>b.lastOpenedAt-a.lastOpenedAt)[0];
  document.getElementById('lastOpenedBox').innerHTML = last ? `
    <h4>Terakhir Dibuka</h4>
    <div class="last-opened" id="lastOpenedCard"><div class="t">🕘 Buka Kembali</div><div class="n">📁 ${esc(last.name)}</div></div>` : '';
  if(last) document.getElementById('lastOpenedCard').addEventListener('click', ()=>openFolder(last.id));

  document.getElementById('folderList').innerHTML = folders.length ? folders.map(f=>`
    <div class="folder-item ${view==='folder' && activeFolderId===f.id?'active':''}" data-open="${f.id}">
      <span class="fname">📁 ${esc(f.name)}</span>
      <span class="del" data-del="${f.id}" title="Hapus folder">✕</span>
    </div>`).join('') : '<div style="font-size:.8rem;color:var(--muted);padding:6px 10px;">Belum ada folder</div>';

  document.querySelectorAll('#folderList [data-open]').forEach(el=>el.addEventListener('click', e=>{
    if(e.target.dataset.del) return;
    openFolder(Number(el.dataset.open));
  }));
  document.querySelectorAll('#folderList [data-del]').forEach(el=>el.addEventListener('click', async e=>{
    e.stopPropagation();
    const id = Number(el.dataset.del);
    const prods = await all('products');
    const count = prods.filter(p=>p.folderId===id).length;
    confirmModal('Hapus Folder?', `Folder ini${count?` beserta ${count} catatan barang di dalamnya`:''} akan dihapus permanen.`, async ()=>{
      await del('folders', id);   // barang di dalamnya ikut terhapus oleh database (FK cascade)
      markWrite();
      if(activeFolderId===id){ view='dashboard'; activeFolderId=null; }
      toast('Folder dihapus'); render();
    });
  }));
}

/* ---------------- main render ---------------- */
// Setiap render diberi nomor urut. Bila pengguna sudah berpindah halaman/folder sebelum render lama selesai (server lambat),
// hasil render lama dibuang supaya tidak menimpa layar yang baru (dulu bisa terjadi judul folder A dengan isi folder B).
let renderSeq = 0;
// Jalankan pembuat halaman; bila server lambat tampilkan "Memuat…" (supaya klik terasa direspons), bila gagal tampilkan pesan + tombol Coba lagi
// (dulu gagal diam-diam sehingga layar tidak berubah sama sekali).
async function renderPage(my, c, fn){
  const timer = setTimeout(()=>{ if(my === renderSeq) c.innerHTML = '<div class="empty">⏳ Memuat…</div>'; }, 250);
  try{ return await fn(); }
  catch(err){
    clearTimeout(timer);
    if(my === renderSeq){
      const msg = (err && err.message) ? err.message : String(err);
      c.innerHTML = '<div class="empty">⚠️ Gagal memuat halaman.<br><span style="font-size:.8rem;color:var(--muted)">' + esc(msg) + '</span><br><button class="btn small" id="retryRender" style="margin-top:10px">Coba lagi</button></div>';
      const rb = document.getElementById('retryRender'); if(rb) rb.onclick = ()=>render();
    }
    return null;
  } finally { clearTimeout(timer); }
}
async function render(){
  const my = ++renderSeq;
  renderStorageInd();
  const sb = renderSidebar().catch(()=>{});          // sidebar dimuat bersamaan; tidak menahan isi halaman
  const c = document.getElementById('content');
  const fab = document.getElementById('fabAdd');
  fab.style.display='flex'; fab.onclick=null;
  const fresh = () => my === renderSeq;
  const pg = fn => renderPage(my, c, fn);

  if(searchQuery){ const h = await pg(pageSearch); if(h == null || !fresh()) return; c.innerHTML = h; fab.style.display='none'; await sb; return; }

  if(view==='dashboard'){ const h = await pg(pageDashboard); if(h == null || !fresh()) return; c.innerHTML = h; fab.onclick = openFolderModal; }
  else if(view==='folder'){ const h = await pg(pageFolder); if(h == null || !fresh()) return; c.innerHTML = h; wireFolderPage(); fab.onclick = ()=>openProductModal(); }
  else if(view==='memo'){ const h = await pg(pageMemo); if(h == null || !fresh()) return; c.innerHTML = h; wireMemo(); fab.onclick = ()=>{ activeMemoId=null; memoDraft=null; memoUid=null; view='memo-editor'; render(); }; }
  else if(view==='memo-editor'){ const h = await pg(pageMemoEditor); if(h == null || !fresh()) return; c.innerHTML = h; wireMemoEditor(); fab.style.display='none'; }
  else if(view==='sheets'){ const h = await pg(pageSheets); if(h == null || !fresh()) return; c.innerHTML = h; wireSheets(); fab.onclick = ()=>openSheetModal(); }
  else if(view==='sheet'){ const h = await pg(pageSheetDetail); if(h == null || !fresh()) return; c.innerHTML = h; wireSheetDetail(); fab.style.display='none'; }
  else if(view==='history'){ const h = await pg(pageHistory); if(h == null || !fresh()) return; c.innerHTML = h; wireHistory(); fab.style.display='none'; }
  await sb;
}

function relTime(ts){
  if(!ts) return '';
  const s = Math.max(0, (Date.now() - ts) / 1000);
  if(s < 60) return 'baru saja';
  if(s < 3600) return Math.floor(s / 60) + ' menit lalu';
  if(s < 86400) return Math.floor(s / 3600) + ' jam lalu';
  const d = Math.floor(s / 86400);
  if(d === 1) return 'kemarin';
  if(d < 7) return d + ' hari lalu';
  return fmtDate(new Date(ts).toISOString());
}
function memoSnippet(m){
  const bl = getMemoBlocks(m);
  const txt = bl.filter(b=>b.type === 'text').map(b=>b.html.replace(/<\/(p|div|li)>/g, ' ').replace(/<[^>]*>/g, '')
    .replace(/&nbsp;/g, ' ').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"').replace(/&#39;/g, "'").replace(/&amp;/g, '&')
    .replace(/\s+/g, ' ').trim()).join(' ').trim();
  if(txt) return txt.length > 90 ? txt.slice(0, 90) + '…' : txt;
  if(bl.some(b=>b.type === 'table')) return '📊 Berisi tabel';
  if(bl.some(b=>b.type === 'checklist')) return '☑ Berisi checklist';
  if(bl.some(b=>b.type === 'image')) return '🖼 Berisi foto';
  return 'Memo kosong';
}
async function pageDashboard(){
  const [foldersRaw, memos, prods, sheets, acts] = await Promise.all([all('folders'), all('memos'), all('products'), all('sheets'), all('activity')]);
  const folders = foldersRaw.sort((a,b)=>b.createdAt - a.createdAt);
  const last = folders.filter(f=>f.lastOpenedAt).sort((a,b)=>b.lastOpenedAt - a.lastOpenedAt)[0];
  const hr = new Date().getHours();
  const greet = hr < 11 ? 'Selamat pagi' : hr < 15 ? 'Selamat siang' : hr < 18 ? 'Selamat sore' : 'Selamat malam';
  const today = new Date().toLocaleDateString('id-ID', {weekday:'long', day:'numeric', month:'long', year:'numeric'});
  const recent = [
    ...folders.filter(f=>f.lastOpenedAt).map(f=>({t:'folder', id:f.id, title:f.name, ts:f.lastOpenedAt, icon:'📁', label:'Folder'})),
    ...memos.map(m=>({t:'memo', id:m.id, title:m.title || '(Tanpa judul)', ts:m.updatedAt || m.createdAt, icon:'📝', label:'Memo'})),
    ...sheets.map(s=>({t:'sheet', id:s.id, title:s.name, ts:s.updatedAt || s.createdAt, icon:'📊', label:'Tabel'}))
  ].sort((a,b)=>b.ts - a.ts).slice(0, 5);
  const recentMemos = [...memos].sort((a,b)=>(b.updatedAt || b.createdAt) - (a.updatedAt || a.createdAt)).slice(0, 3);
  const recentActs = [...acts].sort((a,b)=>b.ts - a.ts).slice(0, 4);
  const chart = folderCountChartSVG(folders, prods);
  const count = fid => prods.filter(p=>p.folderId === fid).length;
  const ACT_ICON = {add:'➕', edit:'✏️', delete:'🗑️'};
  return `
  <section class="dash-hero">
    <div class="hero-text">
      <div class="hero-date">${esc(today)}</div>
      <h1 class="hero-title">${greet} 👋</h1>
      <p class="hero-sub">Buku catatan gudang digitalmu rapi, aman, dan siap dipakai — bahkan tanpa internet.</p>
      ${last ? `<button class="hero-cta" data-open="${last.id}">Lanjutkan: 📁 ${esc(last.name)} →</button>` : `<button class="hero-cta" data-qa="folder">＋ Buat folder pertamamu</button>`}
    </div>
    <div class="hero-art" aria-hidden="true"><div class="art-book">📓</div><div class="art-chip c1">📁</div><div class="art-chip c2">📝</div><div class="art-chip c3">📊</div></div>
  </section>
  <div class="qa-row">
    <button class="qa-btn" data-qa="folder"><span>📁</span> Folder baru</button>
    <button class="qa-btn" data-qa="memo"><span>📝</span> Memo baru</button>
    <button class="qa-btn" data-qa="sheet"><span>📊</span> Tabel baru</button>
  </div>
  <div class="stat-row3">
    <div class="stat-card click" data-go="folders"><div class="si blue">📁</div><div class="sb"><div class="sl">Folder</div><div class="sn">${folders.length}</div></div></div>
    <div class="stat-card click" data-go="memo"><div class="si pink">📝</div><div class="sb"><div class="sl">Memo</div><div class="sn">${memos.length}</div></div></div>
    <div class="stat-card click" data-go="sheets"><div class="si amber">📊</div><div class="sb"><div class="sl">Tabel</div><div class="sn">${sheets.length}</div></div></div>
  </div>
  <div class="dash-grid">
    <div class="dash-card">
      <h4>Barang per Folder</h4>
      ${chart || '<div class="dash-empty">Belum ada folder. Buat folder lalu catat barang pertamamu 📦</div>'}
    </div>
    <div class="dash-card">
      <h4>Terakhir dikerjakan</h4>
      ${recent.length ? recent.map(r=>`
        <div class="recent-row" data-recent="${r.t}:${r.id}">
          <div class="ri">${r.icon}</div>
          <div class="rt"><b>${esc(r.title)}</b><span>${r.label}</span></div>
          <div class="rtime">${relTime(r.ts)}</div>
        </div>`).join('') : '<div class="dash-empty">Belum ada aktivitas. Mulai dengan membuat folder, memo, atau tabel ✨</div>'}
    </div>
  </div>
  <div id="folderSection"><h4 class="sec-h">Folder saya</h4></div>
  <div class="folder-grid">
    ${folders.map(f=>`<div class="fcard" data-open="${f.id}"><div class="icon">📁</div><div class="fn">${esc(f.name)}</div><div class="fc">${count(f.id)} barang · dibuat ${fmtDate(new Date(f.createdAt).toISOString())}</div></div>`).join('')}
    ${!folders.length ? '<div class="empty" style="grid-column:1/-1;">Belum ada folder. Buat folder pertama untuk mulai mencatat.</div>' : ''}
  </div>
  <div style="margin-top:18px;display:grid;grid-template-columns:1fr;gap:18px;">
    <div>
      <h4 class="sec-h">📝 Memo terbaru <span class="more" data-go="memo">Lihat semua →</span></h4>
      ${recentMemos.length ? `<div class="mini-memos">${recentMemos.map(m=>`
        <div class="mini-memo" data-recent="memo:${m.id}"><b>${esc(m.title) || '(Tanpa judul)'}</b><p>${esc(memoSnippet(m))}</p><small>${relTime(m.updatedAt || m.createdAt)}</small></div>`).join('')}</div>`
        : '<div class="dash-card"><div class="dash-empty">Belum ada memo. Tekan “Memo baru” untuk mulai menulis.</div></div>'}
    </div>
    <div>
      <h4 class="sec-h">🕒 Aktivitas terbaru <span class="more" data-go="history">Lihat semua →</span></h4>
      <div class="dash-card">
        ${recentActs.length ? recentActs.map(a=>`<div class="act-row"><span>${ACT_ICON[a.type] || '•'}</span><span style="flex:1;min-width:0;">${ACT_LABEL[a.type] || a.type} ${ENTITY_LABEL[a.entity] || a.entity} — <b>${esc(a.entityName || '-')}</b></span><span class="rtime">${relTime(a.ts)}</span></div>`).join('')
          : '<div class="dash-empty">Belum ada aktivitas tercatat.</div>'}
      </div>
    </div>
  </div>
  `;
}

const wireOnce = (el, fn) => { if(el._w) return; el._w = 1; el.addEventListener('click', fn); };   // satu elemen = satu pendengar klik, walau wire dipanggil berulang
function wireDashboardExtra(){
  // Hanya kartu di area isi (sidebar sudah punya pendengar sendiri) dan hanya sekali per elemen; dulu satu klik memanggil openFolder 3x.
  document.querySelectorAll('#content [data-open]').forEach(el=>{ if(el.dataset.open && !el._wo){ el._wo = 1; el.addEventListener('click', ()=>openFolder(Number(el.dataset.open))); } });
  const ms = document.getElementById('memoShortcut'); if(ms) wireOnce(ms, ()=>{ view='memo'; render(); });
  document.querySelectorAll('[data-qa]').forEach(b=>wireOnce(b, ()=>{
    const k = b.dataset.qa;
    if(k === 'folder') openFolderModal();
    else if(k === 'memo'){ activeMemoId = null; memoDraft = null; memoUid = null; view = 'memo-editor'; render(); }
    else if(k === 'sheet') openSheetModal();
  }));
  document.querySelectorAll('[data-go]').forEach(el=>wireOnce(el, ()=>{
    const k = el.dataset.go;
    if(k === 'memo'){ view = 'memo'; render(); }
    else if(k === 'sheets'){ view = 'sheets'; activeSheetId = null; render(); }
    else if(k === 'history'){ view = 'history'; render(); }
    else if(k === 'folders'){ const s = document.getElementById('folderSection'); if(s && s.scrollIntoView) s.scrollIntoView({behavior:'smooth'}); }
  }));
  document.querySelectorAll('[data-recent]').forEach(el=>wireOnce(el, ()=>{
    const [t, id] = el.dataset.recent.split(':'), n = Number(id);
    if(t === 'folder') openFolder(n);
    else if(t === 'memo'){ activeMemoId = n; view = 'memo-editor'; render(); }
    else if(t === 'sheet'){ activeSheetId = n; view = 'sheet'; render(); }
  }));
}

async function pageFolder(){
  const f = (await all('folders')).find(x=>x.id === activeFolderId);   // dari data yang sudah dimuat (tanpa menunggu server lagi)
  if(!f){ view='dashboard'; return pageDashboard(); }
  const prods = (await all('products')).filter(p=>p.folderId===activeFolderId).sort((a,b)=>b.createdAt-a.createdAt);
  return `
  <div class="crumb" id="backToDash">← Semua Folder</div>
  <div class="section-title">📁 ${esc(f.name)}</div>
  <div class="section-sub">${prods.length} catatan barang di folder ini</div>
  <div class="product-grid">
    ${prods.map(p=>`
    <div class="pcard" data-pid="${p.id}">
      ${p.photo?`<img class="pphoto" src="${p.photo}" alt="${esc(p.name)}">`:(p.hasPhoto?`<img class="pphoto" data-lazyphoto="${p.id}" alt="${esc(p.name)}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="min-height:120px;background:var(--bg)">`:'')}
      <div class="pbody">
        <div class="ptop"><div class="pname">${esc(p.name)}</div><button class="menu-btn" data-menu="${p.id}">⋮</button></div>
        <div class="prow"><span class="k">Harga</span><span class="v">${rupiah(p.price)}</span></div>
        <div class="prow"><span class="k">Isi Dus</span><span class="v">${boxDisplay(p.boxQty)}</span></div>
        <div class="prow"><span class="k">Isi Box</span><span class="v">${p.smallBoxQty ?? '-'} ${p.smallBoxQty?'pcs':''}</span></div>
        <div class="prow"><span class="k">Harga Jual</span><span class="v">${rupiah(p.sellingPrice)}</span></div>
        <div class="pdate">🗓 ${fmtDate(p.date)}</div>
      </div>
    </div>`).join('')}
    ${!prods.length?'<div class="empty" style="grid-column:1/-1;">Belum ada catatan barang di folder ini. Tekan + untuk menambah.</div>':''}
  </div>`;
}
function wireFolderPage(){
  if(typeof loadFolderPhotos === 'function') loadFolderPhotos(activeFolderId);   // foto barang menyusul setelah halaman tampil (versi server)
  const back = document.getElementById('backToDash');
  if(back) back.addEventListener('click', ()=>{ view='dashboard'; activeFolderId=null; render(); });
  document.querySelectorAll('[data-menu]').forEach(btn=>btn.addEventListener('click', e=>{
    e.stopPropagation();
    document.querySelectorAll('.menu-pop').forEach(m=>m.remove());
    const id = Number(btn.dataset.menu);
    const pop = document.createElement('div');
    pop.className='menu-pop';
    pop.innerHTML = `<button data-e>Edit</button><button class="danger" data-h>Hapus</button>`;
    btn.parentElement.appendChild(pop);
    pop.querySelector('[data-e]').onclick = ()=>{ pop.remove(); openProductModal(id); };
    pop.querySelector('[data-h]').onclick = async ()=>{
      pop.remove();
      const p = (await all('products')).find(x=>x.id === id);
      confirmModal('Hapus Barang?', 'Data ini akan dihapus.', async ()=>{
        await logActivity('delete','product', p.name, p);
        await del('products', id); markWrite(); toast('Barang dihapus'); render();
      }, p.name);
    };
    document.addEventListener('click', function close(ev){ if(!pop.contains(ev.target) && ev.target!==btn){ pop.remove(); document.removeEventListener('click', close); } });
  }));
  wireDashboardExtra();
}

/* ---------------- Riwayat / Undo ---------------- */
async function logActivity(){}   // riwayat ditulis otomatis oleh trigger database
const ACT_LABEL = {add:'Tambah', edit:'Ubah', delete:'Hapus'};
const ENTITY_LABEL = {folder:'Folder', product:'Barang', memo:'Memo'};
async function pageHistory(){
  // goneActs/histClearedUpTo: catatan yang sudah dihapus pengguna tidak boleh muncul lagi walau data lama dari cache/server terlambat tiba
  const acts = (await all('activity')).filter(a=>!goneActs.has(a.id) && a.id > histClearedUpTo).sort((a,b)=>b.ts-a.ts).slice(0,80);
  return `
  <div class="section-title">🕒 Riwayat Perubahan</div>
  <div class="section-sub">Catatan aktivitas terakhir. Penghapusan bisa diurungkan (undo) selama datanya masih ada di sini.</div>
  ${acts.length ? `<div class="hist-bar"><span>${acts.length} catatan</span><button class="btn small danger" id="histClear">🗑 Hapus semua riwayat</button></div>` : ''}
  ${acts.length ? acts.map(a=>`
    <div class="row" style="padding:11px 4px;display:flex;align-items:center;gap:8px;">
      <span style="flex:1;min-width:0;">${a.type==='delete'?'🗑️':a.type==='edit'?'✏️':'➕'} ${ACT_LABEL[a.type]||a.type} ${ENTITY_LABEL[a.entity]||a.entity} — <b>${esc(a.entityName||'-')}</b><span style="display:block;color:var(--muted);font-size:.74rem;margin-top:2px;">${new Date(a.ts).toLocaleString('id-ID')}</span></span>
      ${a.type==='delete' && a.snapshot && !a.undone ? `<button class="btn small ghost" data-undo="${a.id}">↩ Urungkan</button>` : (a.undone?'<span class="tag" style="border-color:var(--green);color:var(--green);">Diurungkan</span>':'')}
      <button class="btn small ghost hist-del" data-actdel="${a.id}" title="Hapus catatan riwayat ini" aria-label="Hapus riwayat ini">🗑</button>
    </div>`).join('') : '<div class="empty">Belum ada aktivitas tercatat.</div>'}`;
}
const goneActs = new Set(); let histClearedUpTo = 0;
function wireHistory(){
  // Hapus 1 catatan riwayat. Penghapusan yang masih bisa diurungkan diberi konfirmasi karena tombol "Urungkan"-nya ikut hilang.
  document.querySelectorAll('[data-actdel]').forEach(btn=>btn.addEventListener('click', async ()=>{
    const id = Number(btn.dataset.actdel), row = btn.closest('.row'), canUndo = !!row.querySelector('[data-undo]');
    const doDel = async()=>{ goneActs.add(id); row.remove(); try{ await del('activity', id); if(!document.querySelector('[data-actdel]')) render(); else { const n = document.querySelectorAll('[data-actdel]').length, c = document.querySelector('.hist-bar span'); if(c) c.textContent = n + ' catatan'; } }catch(e){ if(e && e.status === 404) return; goneActs.delete(id); toast((e && e.message ? e.message : 'Gagal menghapus riwayat') + ' - muat ulang halaman lalu coba lagi', 4500); render(); } };
    if(canUndo) confirmModal('Hapus catatan ini?', 'Catatan ini masih bisa diurungkan. Kalau dihapus, datanya tidak bisa dipulihkan lagi lewat Riwayat.', doDel, null, 'Hapus'); else doDel();
  }));
  const hc = document.getElementById('histClear');
  if(hc) hc.addEventListener('click', ()=>confirmModal('Hapus semua riwayat?', 'Semua catatan riwayat dihapus, termasuk tombol "Urungkan" untuk penghapusan sebelumnya. Data barang, memo, dan tabel TIDAK ikut terhapus.', async()=>{
    try{
      const all0 = await all('activity'); histClearedUpTo = Math.max(histClearedUpTo, ...all0.map(a=>a.id), 0);
      if(typeof clearAllActivity === 'function') await clearAllActivity();
      else for(const a of await all('activity')) await del('activity', a.id);
      toast('Riwayat dikosongkan'); render();
    }catch(e){ toast('Gagal menghapus riwayat'); }
  }, null, 'Hapus semua'));
  document.querySelectorAll('[data-undo]').forEach(btn=>btn.addEventListener('click', async ()=>{
    try{
      await api('activities/' + Number(btn.dataset.undo) + '/undo', {method:'POST'});   // server: transaksi + rollback bila gagal
      bust('folders', 'products', 'memos', 'sheets', 'activity'); shLocal.clear();
      markWrite(); toast('Berhasil diurungkan'); render();
    }catch(e){ toast(e.message || 'Gagal mengurungkan perubahan'); }
  }));
}

/* ---------------- dashboard mini chart ---------------- */
function folderCountChartSVG(folders, prods){
  if(!folders.length) return '';
  const data = folders.map(f=>({name:f.name, n: prods.filter(p=>p.folderId===f.id).length})).sort((a,b)=>b.n-a.n).slice(0,6);
  const max = Math.max(1, ...data.map(d=>d.n));
  const barH=20, gap=16, leftW=132, trackW=220, topPad=4;
  const h = data.length*(barH+gap)+topPad;
  const bars = data.map((d,i)=>{
    const y = topPad + i*(barH+gap);
    const w = Math.max(6, Math.round((d.n/max)*trackW));
    const label = esc(d.name).length>18 ? esc(d.name).slice(0,17)+'…' : esc(d.name);
    return `<text x="0" y="${y+barH*0.7}" font-size="12" fill="var(--muted,#64748B)" font-weight="600">${label}</text>
      <rect x="${leftW}" y="${y}" width="${trackW}" height="${barH}" rx="6" fill="var(--blue-soft,#EFF4FE)"></rect>
      <rect x="${leftW}" y="${y}" width="${w}" height="${barH}" rx="6" fill="var(--blue,#3B82F6)"></rect>
      <text x="${leftW+trackW+10}" y="${y+barH*0.7}" font-size="12" fill="var(--ink,#1E293B)" font-weight="800">${d.n}</text>`;
  }).join('');
  return `<svg viewBox="0 0 ${leftW+trackW+40} ${h}" width="100%" style="max-width:460px;height:auto;display:block;">${bars}</svg>`;
}

/* ---------------- Memo: multi-block model (text / table / checklist) ---------------- */
// Migration: old memos only had plain `content` (string) or `kind==='table'` with
// JSON content. We never rewrite old records on disk — we just normalize them into
// the new `blocks` shape whenever they're displayed or opened for editing.
function getMemoBlocks(m){
  if(Array.isArray(m.blocks)) return m.blocks;
  if(m.kind === 'table'){
    try{ const d = JSON.parse(m.content); return [{type:'text',html:'<p></p>'}, {type:'table', header:d.header, rows:d.rows}, {type:'text',html:'<p></p>'}]; }
    catch(e){ /* fall through */ }
  }
  const text = m.content || '';
  const html = '<p>' + (text ? esc(text).replace(/\n/g,'</p><p>') : '') + '</p>';
  return [{type:'text', html}];
}
// Sel tabel memo disimpan sebagai HTML (b.rich = true) supaya bisa dicetak tebal/miring/berwarna. Memo lama (teks biasa) dikonversi saat dibuka.
function normBlocks(bl){
  bl.forEach(b=>{ if(b.type === 'table' && !b.rich){ b.header = b.header.map(h=>esc(h)); b.rows = b.rows.map(r=>r.map(v=>esc(v))); b.rich = true; } });
  return bl;
}
function renderBlockReadOnly(b){
  if(b.type === 'table'){
    const cell = v => b.rich ? v : esc(v);
    const thead = '<tr><th></th>' + b.header.map(h=>`<th>${cell(h)}</th>`).join('') + '</tr>';
    const tbody = b.rows.map((row,r)=>`<tr><td class="rh">${r+1}</td>${row.map(v=>`<td><div class="cellval">${cell(v)}</div></td>`).join('')}</tr>`).join('');
    return `<div class="memo-table-wrap"><table class="memo-table"><thead>${thead}</thead><tbody>${tbody}</tbody></table></div>`;
  }
  if(b.type === 'checklist'){
    return `<div class="memo-checklist readonly">${b.items.map(it=>`<div class="chk-row ro"><input type="checkbox" disabled ${it.done?'checked':''}><span style="${it.done?'text-decoration:line-through;opacity:.6;':''}">${esc(it.text)}</span></div>`).join('')}</div>`;
  }
  if(b.type === 'image' && !b.src){ const lay = IMG_LAYS.some(x=>x[0]===b.lay) ? b.lay : 'l'; return `<div class="mc imgblk imgph lay-${lay}" style="width:${Number(b.w) || 66}%">🖼 Memuat foto…</div>`; }   // daftar dari server tidak membawa isi foto (lihat UiStoreController::index)
  if(b.type === 'image'){ const lay = IMG_LAYS.some(x=>x[0]===b.lay) ? b.lay : 'l'; return `<div class="mc imgblk lay-${lay}" style="width:${Number(b.w) || 66}%"><img class="memo-photo" src="${esc(b.src)}" alt="Foto memo"></div>`; }
  return `<div class="mc${b.clr ? ' clr' : ''}">${b.html}</div>`;
}
// Tata letak foto memo: l=kiri, c=tengah, r=kanan, wl/wr = foto di kiri/kanan dan teks mengalir di sebelahnya.
const IMG_LAYS = [['l','⬅','Foto di kiri'],['c','↔','Foto di tengah'],['r','➡','Foto di kanan'],['wl','▤◧','Foto kiri, teks di sebelah kanan'],['wr','◨▤','Foto kanan, teks di sebelah kiri']];
const isWrapImg = b => !!b && b.type === 'image' && (b.lay === 'wl' || b.lay === 'wr');
const isEmptyText = b => !!b && b.type === 'text' && !String(b.html || '').replace(/<[^>]*>|&nbsp;/g, '').trim();
// Blok teks kosong yang terjepit di antara dua foto "teks mengalir" disembunyikan, supaya kedua foto sejajar (bersebelahan, sama tinggi).
const isGapBetweenWraps = (arr, i) => isEmptyText(arr[i]) && isWrapImg(arr[i-1]) && isWrapImg(arr[i+1]);
// Memo hasil "Salin ke Memo" adalah salinan: tidak tersambung ke Tabel asalnya.
function memoBodyHtml(m){ return memoCopyLabel(m) + getMemoBlocks(m).map((b, i, arr)=>isGapBetweenWraps(arr, i) ? '' : renderBlockReadOnly(b)).join(''); }
// Jam terakhir memo diubah, di sudut kanan bawah kartu.
function memoTimeLabel(m){
  const ts = m.updatedAt || m.createdAt; if(!ts) return '';
  const d = new Date(ts); if(isNaN(d)) return '';
  const now = new Date(), same = d.toDateString() === now.toDateString();
  const jam = d.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'});
  const tgl = same ? '' : d.toLocaleDateString('id-ID', {day:'numeric', month:'short'}) + ', ';
  return `<span class="mtime" title="Terakhir diubah">🕒 ${tgl}${jam}</span>`;
}
// Foto memo dimuat saat kartu dibuka (daftar dari server tidak membawa isi foto supaya semua halaman tetap ringan).
async function fillMemoImages(card){
  const id = Number(card.dataset.mid), bd = card.querySelector('.mbody');
  if(!bd || !bd.querySelector('.imgph')) return;
  try{ const full = await get('memos', id); if(full && card.isConnected){ bd.innerHTML = memoBodyHtml(full); fitMemoPreview(card); } }catch(e){}
}
function memoCopyLabel(m){
  const hasTable = getMemoBlocks(m).some(b=>b.type === 'table');
  if(m.fromSheet) return `<div class="memo-src">📋 Salinan dari tabel “${esc(m.fromSheet.name)}” — tidak tersambung ke Tabel</div>`;
  if(hasTable && (m.title || '').startsWith('Tabel: ')) return '<div class="memo-src">📋 Salinan tabel hasil export — tidak tersambung ke Tabel</div>';
  return '';
}
async function pageMemo(){
  const memos = (await all('memos')).sort((a,b)=>b.createdAt-a.createdAt);
  return `
  <div class="section-title">📝 Memo</div>
  <div class="section-sub">Catatan tambahan, terpisah dari data barang.</div>
  ${memos.length ? memos.map(m=>`
    <div class="memo-item compact${memoOpen.has(m.id)?' open':''}" data-mid="${m.id}">
      <div class="mhead" data-mtoggle="${m.id}" role="button" tabindex="0" aria-expanded="${memoOpen.has(m.id)}">
        <div class="mh-main">
          <div class="mt">${esc(m.title) || '<span style="opacity:.6">(Tanpa judul)</span>'}</div>
          <div class="md">${fmtDate(m.date)}</div>
          <div class="msn">${esc(memoSnippet(m))}</div>
        </div>
        <span class="mchev" aria-hidden="true">▾</span>
      </div>
      <div class="mbody clamp">${memoBodyHtml(m)}</div>
      <button type="button" class="mmore" data-mmore="${m.id}">Tampilkan semua ▾</button>
      <div class="actions"><button class="btn small ghost" data-medit="${m.id}">Edit</button><button class="btn small danger" data-mdel="${m.id}">Hapus</button>${memoTimeLabel(m)}</div>
    </div>`).join('') : '<div class="empty">Belum ada memo. Tekan + untuk membuat catatan.</div>'}
  `;
}
const memoOpen = new Set();   // memo yang sedang dibuka lengkap di daftar (default: ringkas)
// Memo yang baru dibuka tampil sebagai pratinjau (tinggi dibatasi); tombol hanya muncul bila isinya memang lebih panjang.
function fitMemoPreview(card){
  const bd = card.querySelector('.mbody'), more = card.querySelector('.mmore'); if(!bd || !more) return;
  bd.classList.add('clamp'); more.textContent = 'Tampilkan semua ▾';
  more.classList.toggle('show', bd.scrollHeight > bd.clientHeight + 4);
}
function wireMemo(){
  document.querySelectorAll('.memo-item.open').forEach(c=>{ fitMemoPreview(c); fillMemoImages(c); });
  document.querySelectorAll('[data-mmore]').forEach(b=>b.addEventListener('click', ()=>{ const bd = b.closest('.memo-item').querySelector('.mbody'); const full = bd.classList.toggle('clamp') === false; b.textContent = full ? 'Ringkas ▴' : 'Tampilkan semua ▾'; }));
  document.querySelectorAll('[data-mtoggle]').forEach(h=>{
    const go = ()=>{ const id = Number(h.dataset.mtoggle), card = h.closest('.memo-item'); const o = !memoOpen.has(id); o ? memoOpen.add(id) : memoOpen.delete(id); card.classList.toggle('open', o); h.setAttribute('aria-expanded', o); if(o){ fitMemoPreview(card); fillMemoImages(card); } };
    h.addEventListener('click', go); h.addEventListener('keydown', e=>{ if(e.key === 'Enter' || e.key === ' '){ e.preventDefault(); go(); } });
  });
  document.querySelectorAll('[data-medit]').forEach(b=>b.addEventListener('click',()=>{ activeMemoId=Number(b.dataset.medit); view='memo-editor'; render(); }));
  document.querySelectorAll('[data-mdel]').forEach(b=>b.addEventListener('click', async ()=>{
    confirmModal('Hapus Memo?','Catatan ini akan dihapus.', async()=>{
      const m = await get('memos', Number(b.dataset.mdel));
      await logActivity('delete','memo', m?.title, m);
      await del('memos', Number(b.dataset.mdel)); markWrite(); toast('Memo dihapus'); render();
    });
  }));
}

/* ---------------- Memo editor (full page, multi-block) ---------------- */
let editorBlocks = [];
const ICON_UNDO = '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 14 4 9l5-5"/><path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5 5.5 5.5 0 0 1-5.5 5.5H11"/></svg>';
const ICON_REDO = '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 14 5-5-5-5"/><path d="M20 9H9.5A5.5 5.5 0 0 0 4 14.5 5.5 5.5 0 0 0 9.5 20H13"/></svg>';
// Hasil "Salin ke Memo" berupa DRAFT: baru masuk daftar Memo setelah tombol Simpan ditekan.
let memoDraft = null, editorFromSheet = null, editorIsDraft = false, editorOriginal = null;
const ICON_AL = {
  left: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 10h10M4 14h16M4 18h10"/></svg>',
  center: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M7 10h10M4 14h16M7 18h10"/></svg>',
  right: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M10 10h10M4 14h16M10 18h10"/></svg>'
};
let editorCreatedAt = null;


// ketik "1. " / "- " di awal baris -> otomatis jadi daftar bernomor / berpoin
function autoList(e){
  if(!e || e.inputType !== 'insertText' || !/^[\s\u00a0]$/.test(e.data||'')) return;
  const sel = getSelection(); if(!sel.rangeCount || !sel.isCollapsed) return;
  const n = sel.anchorNode; if(!n || n.nodeType !== 3) return;
  const blk = n.parentNode && n.parentNode.closest ? n.parentNode.closest('.memo-editor-block') : null;
  if(!blk || n.parentNode.closest('li')) return;
  const prev = n.previousSibling;
  if(prev && !(prev.nodeName === 'BR' || /^(DIV|P)$/.test(prev.nodeName))) return;
  const m = /^(\d+[.)]|[-*•])[\s\u00a0]$/.exec(n.textContent.slice(0, sel.anchorOffset));
  if(!m || sel.anchorOffset !== n.textContent.length) return;
  for(let k = 0; k < m[0].length; k++) document.execCommand('delete');
  document.execCommand(/\d/.test(m[1]) ? 'insertOrderedList' : 'insertUnorderedList');
}
function renderEditableBlock(b, i){
  if(b.type === 'table'){
    const thead = '<tr><th></th>' + b.header.map((h,c)=>`<th><div class="cellval" contenteditable="true" data-b="${i}" data-h="${c}">${h}</div></th>`).join('') + '</tr>';
    const tbody = b.rows.map((row,r)=>`<tr><td class="rh">${r+1}</td>${row.map((v,c)=>`<td><div class="cellval" contenteditable="true" data-b="${i}" data-r="${r}" data-c="${c}">${v}</div></td>`).join('')}</tr>`).join('');
    return `<div class="memo-table-wrap" data-block="${i}">
      <table class="memo-table"><thead>${thead}</thead><tbody>${tbody}</tbody></table>
      <div class="table-block-actions">
        <button type="button" class="btn small ghost" data-tbl-addrow="${i}" title="Tambah baris di bawah sel yang sedang diketik (atau di akhir)">+ Baris</button>
        <button type="button" class="btn small ghost" data-tbl-addcol="${i}" title="Tambah kolom di kanan sel yang sedang diketik (atau di akhir)">+ Kolom</button>
        <button type="button" class="btn small ghost" data-tbl-delrow="${i}" title="Hapus baris sel yang sedang diketik (atau baris terakhir)">− Baris</button>
        <button type="button" class="btn small ghost" data-tbl-delcol="${i}" title="Hapus kolom sel yang sedang diketik (atau kolom terakhir)">− Kolom</button>
        <button type="button" class="btn small danger" data-tbl-remove="${i}">Hapus Tabel</button>
      </div>
    </div>`;
  }
  if(b.type === 'image'){
    const w = Number(b.w) || 66;
    const lay = IMG_LAYS.some(x=>x[0]===b.lay) ? b.lay : 'l';
    return `<div class="memo-img-wrap lay-${lay}" data-block="${i}" tabindex="0" style="width:${w}%"><img src="${esc(b.src)}" alt="Foto memo" draggable="false">
      <div class="img-actions">
        ${[[25,'S'],[33,'Kecil'],[50,'Sedang'],[66,'Besar'],[100,'Penuh']].map(([v,l])=>`<button type="button" class="${w===v?'on':''}" data-imgw="${i}:${v}">${l}</button>`).join('')}
        <button type="button" class="del" data-imgdel="${i}" aria-label="Hapus foto">Hapus</button>
        <span class="img-row2"><button type="button" data-imgbelow="${i}" title="Pindahkan kursor ke baris di bawah foto (teks tidak lagi di samping foto)">↧ Teks di bawah</button>${IMG_LAYS.map(([v,l,t])=>`<button type="button" class="${lay===v?'on':''}" title="${t}" aria-label="${t}" data-imglay="${i}:${v}">${l}</button>`).join('')}</span>
      </div></div>`;
  }
  if(b.type === 'checklist'){
    const itemsHtml = b.items.map((it,ii)=>`
      <div class="chk-row">
        <input type="checkbox" data-chk="${i}:${ii}" ${it.done?'checked':''}>
        <input type="text" class="chk-text" data-chktxt="${i}:${ii}" value="${esc(it.text)}" placeholder="Item checklist...">
        <button type="button" class="chk-del" data-chkdel="${i}:${ii}" title="Hapus item">✕</button>
      </div>`).join('');
    return `<div class="memo-checklist" data-block="${i}">${itemsHtml}<button type="button" class="btn small ghost" data-chkadd="${i}" style="margin-top:4px;">+ Item</button></div>`;
  }
  return `<div class="memo-editor-block${b.clr ? ' clr' : ''}${isGapBetweenWraps(editorBlocks, i) ? ' gap0' : ''}" contenteditable="true" data-block="${i}">${b.html || '<p></p>'}</div>`;
}

async function pageMemoEditor(){
  const draft = (!activeMemoId && memoDraft) ? memoDraft : null; memoDraft = null;
  const m = draft || (activeMemoId ? await get('memos', activeMemoId) : null);
  editorFromSheet = m ? (m.fromSheet || null) : null; editorIsDraft = !!draft;
  editorOriginal = (m && !draft) ? JSON.parse(JSON.stringify(m)) : null;
  editorBlocks = m ? normBlocks(JSON.parse(JSON.stringify(getMemoBlocks(m)))) : [{type:'text', html:'<p></p>'}];
  editorCreatedAt = m ? m.createdAt : null;
  imgPool.clear(); editorBlocks.forEach(b=>{ if(b.type === 'image'){ if(!b.id) b.id = 'img' + Math.random().toString(36).slice(2); imgPool.set(b.id, b.src); } });
  lastTextIdx = null;
  const title = m ? m.title : '';
  const date = m ? m.date : todayISO();
  return `
  <div class="crumb" id="backToMemoList">← Memo</div>
  <input id="me_title" class="autocap-input" placeholder="Judul Catatan" value="${esc(title)}" style="font-size:1.2rem;font-weight:700;border:none;border-bottom:2px solid var(--line);border-radius:0;padding:8px 2px;background:none;width:100%;max-width:480px;display:block;">
  <input id="me_date" type="date" value="${date}" style="margin:10px 0 14px;max-width:200px;">
  ${editorIsDraft ? `<div class="memo-src" style="margin:-6px 0 12px;">📋 Salinan dari tabel “${esc(editorFromSheet ? editorFromSheet.name : '')}”. Otomatis tersimpan ke Memo. Tekan <b>Batal</b> kalau ingin membuangnya.</div>` : ''}
  ${memoToolbarHTML()}
  <div id="me_blocks">${editorBlocks.map((b,i)=>renderEditableBlock(b,i)).join('')}</div>
  <div class="memo-footer"><div class="mf-in">
    <span class="save-status" id="me_status">Tersimpan otomatis saat kamu menulis</span>
    <button class="btn ghost" id="me_cancel">Batal</button>
    <button class="btn" id="me_save">Simpan</button>
  </div></div>`;
}

const cleanCell = h => (h === '<br>' || h === '<div><br></div>') ? '' : h.replace(/<br>$/, '');
function syncTextBlocksFromDOM(){
  document.querySelectorAll('.memo-editor-block[data-block]').forEach(div=>{
    const i = Number(div.dataset.block);
    if(editorBlocks[i] && editorBlocks[i].type==='text') editorBlocks[i].html = div.innerHTML;
  });
  document.querySelectorAll('#me_blocks .cellval[data-b]').forEach(d=>{          // isi sel tabel memo
    const b = editorBlocks[Number(d.dataset.b)]; if(!b || b.type !== 'table') return;
    const h = cleanCell(d.innerHTML);
    if(d.dataset.h != null){ if(b.header[Number(d.dataset.h)] !== undefined) b.header[Number(d.dataset.h)] = h; }
    else if(b.rows[Number(d.dataset.r)]) b.rows[Number(d.dataset.r)][Number(d.dataset.c)] = h;
  });
}
// Menyisipkan tabel / checklist / hasil impor TEPAT di posisi kursor: teks di kiri kursor tetap di atas, teks di kanan kursor pindah ke bawah.
// prepareInsert() dipanggil saat tombol ditekan (kursor masih aktif); applyInsert() dipanggil setelah dialog/impor selesai.
function prepareInsert(){
  syncTextBlocksFromDOM();
  const emptyHtml = h=>{ const d = document.createElement('div'); d.innerHTML = h; return !d.textContent.trim() && !d.querySelector('img,hr,table'); };
  let idx = -1, before = '<p><br></p>', after = '<p><br></p>';
  const sel = window.getSelection();
  if(sel && sel.rangeCount){
    const r = sel.getRangeAt(0), n = r.endContainer, el = n.nodeType === 1 ? n : n.parentElement;
    const host = el && el.closest && el.closest('#me_blocks .memo-editor-block');
    if(host){
      idx = Number(host.dataset.block);
      const hd = document.createRange(); hd.selectNodeContents(host); hd.setEnd(r.endContainer, r.endOffset);
      const tl = document.createRange(); tl.selectNodeContents(host); tl.setStart(r.endContainer, r.endOffset);
      const toHtml = rg=>{ const d = document.createElement('div'); d.appendChild(rg.cloneContents()); return d.innerHTML; };
      before = toHtml(hd); after = toHtml(tl);
    }
  }
  if(idx < 0){                                   // kursor tidak di teks memo: sisipkan setelah blok teks terakhir
    for(let i = editorBlocks.length - 1; i >= 0; i--) if(editorBlocks[i].type === 'text'){ idx = i; break; }
    if(idx >= 0) before = editorBlocks[idx].html;
  }
  if(emptyHtml(before)) before = '<p><br></p>';
  if(emptyHtml(after)) after = '<p><br></p>';
  return {idx, before, after};
}
function applyInsert(ins, blocks, focusKind){
  blocks = normBlocks(blocks);
  const e = editorBlocks; let first;
  if(ins.idx >= 0 && e[ins.idx] && e[ins.idx].type === 'text'){
    e.splice(ins.idx, 1, {type:'text', html:ins.before}, ...blocks, {type:'text', html:ins.after}); first = ins.idx + 1;
  } else { first = e.length; e.push(...blocks, {type:'text', html:'<p><br></p>'}); }
  rerenderBlocks();
  const el = document.getElementById('me_blocks').children[first];
  if(el){
    const f = focusKind !== 'import' && el.querySelector('td .cellval[contenteditable],.chk-text');
    if(f){ f.focus(); try{ f.setSelectionRange && f.setSelectionRange(0,0); }catch(err){} }
    if(el.scrollIntoView) el.scrollIntoView({behavior:'smooth', block:'nearest'});
  }
  // Foto + teks: kursor langsung ke blok teks tepat setelah foto, jadi yang diketik mengalir di sebelah foto.
  if(blocks.some(b=>b.type === 'image' && (b.lay === 'wl' || b.lay === 'wr'))){
    const nx = document.getElementById('me_blocks').children[first + blocks.length];
    if(nx && nx.classList.contains('memo-editor-block')){ nx.focus(); const r = document.createRange(); r.selectNodeContents(nx); r.collapse(true); const sel = getSelection(); sel.removeAllRanges(); sel.addRange(r); }
  }
}
// Item checklist terakhir dihapus = seluruh blok checklist ikut hilang (dulu selalu muncul item kosong baru, jadi tidak bisa dihapus).
function removeChecklistBlock(bi){
  editorBlocks.splice(bi, 1); editorBlocks = mergeTextBlocks(editorBlocks);
  if(!editorBlocks.length) editorBlocks = [{type:'text', html:'<p><br></p>'}];
}
function rerenderBlocks(){
  lastCell = null;
  document.getElementById('me_blocks').innerHTML = editorBlocks.map((b,i)=>renderEditableBlock(b,i)).join('');
  wireBlockInteractions();
  memoCommit(); // setiap perubahan struktur (tabel, checklist, impor, dll.) = satu langkah riwayat
}
let lastCell = null;   // sel tabel memo yang terakhir diketik: {b, r, c} (r = -1 untuk baris judul kolom)
function wireBlockInteractions(){
  const root = document.getElementById('me_blocks');
  root.querySelectorAll('.memo-editor-block[data-block], .cellval[contenteditable]').forEach(div=>{
    div.addEventListener('paste', e=>{                 // tempel selalu sebagai teks biasa (tidak membawa gaya dari luar)
      e.preventDefault();
      let text = (e.clipboardData||window.clipboardData).getData('text/plain');
      if(div.classList.contains('cellval')) text = text.replace(/\s*[\r\n]+\s*/g, ' ');
      document.execCommand('insertText', false, text);
    });
  });
  root.querySelectorAll('.cellval[contenteditable]').forEach(d=>{       // Enter = sel di bawah, Tab = sel berikutnya
    d.addEventListener('keydown', e=>{
      if(e.key !== 'Enter' && e.key !== 'Tab') return;
      const wrap = d.closest('.memo-table-wrap'), cells = [...wrap.querySelectorAll('.cellval[contenteditable]')];
      const ncols = wrap.querySelectorAll('thead th .cellval').length, i = cells.indexOf(d);
      const j = e.key === 'Enter' ? (e.shiftKey ? i - ncols : i + ncols) : (e.shiftKey ? i - 1 : i + 1);
      e.preventDefault(); if(j >= 0 && j < cells.length) focusEnd(cells[j]);
    });
  });
  const here = i => lastCell && lastCell.b === i ? lastCell : null;
  document.querySelectorAll('[data-tbl-addrow]').forEach(b=>b.addEventListener('click', ()=>{
    const i = Number(b.dataset.tblAddrow), blk = editorBlocks[i], lc = here(i);
    const at = lc && lc.r >= 0 ? lc.r + 1 : blk.rows.length;
    blk.rows.splice(at, 0, Array(blk.header.length).fill('')); rerenderBlocks();
  }));
  document.querySelectorAll('[data-tbl-addcol]').forEach(b=>b.addEventListener('click', ()=>{
    const i = Number(b.dataset.tblAddcol), blk = editorBlocks[i], lc = here(i);
    const at = lc ? lc.c + 1 : blk.header.length;
    blk.header.splice(at, 0, colLetter(blk.header.length)); blk.rows.forEach(r=>r.splice(at, 0, '')); rerenderBlocks();
  }));
  document.querySelectorAll('[data-tbl-delrow]').forEach(b=>b.addEventListener('click', ()=>{
    const i = Number(b.dataset.tblDelrow), blk = editorBlocks[i], lc = here(i);
    if(blk.rows.length > 1) blk.rows.splice(lc && lc.r >= 0 ? lc.r : blk.rows.length - 1, 1); else toast('Minimal 1 baris');
    rerenderBlocks();
  }));
  document.querySelectorAll('[data-tbl-delcol]').forEach(b=>b.addEventListener('click', ()=>{
    const i = Number(b.dataset.tblDelcol), blk = editorBlocks[i], lc = here(i);
    if(blk.header.length > 1){ const at = lc ? lc.c : blk.header.length - 1; blk.header.splice(at, 1); blk.rows.forEach(r=>r.splice(at, 1)); } else toast('Minimal 1 kolom');
    rerenderBlocks();
  }));
  document.querySelectorAll('[data-tbl-remove]').forEach(b=>b.addEventListener('click', ()=>{
    const i=Number(b.dataset.tblRemove);
    confirmModal('Hapus Tabel ini?','Tabel akan dihapus dari memo ini (memo-nya sendiri tidak dihapus).', async()=>{
      editorBlocks.splice(i,1);
      editorBlocks = mergeTextBlocks(editorBlocks);                      // teks di atas & bawah tabel menyatu lagi
      if(!editorBlocks.length) editorBlocks=[{type:'text',html:'<p></p>'}];
      rerenderBlocks();
    });
  }));
  document.querySelectorAll('[data-imgbelow]').forEach(b=>b.addEventListener('click', ()=>{
    memoCollect();
    let j = Number(b.dataset.imgbelow);
    for(;;){                                   // lompati foto "teks mengalir" berurutan: teks di bawah harus melewati SEMUANYA
      let k = j + 1; while(isEmptyText(editorBlocks[k])) k++;
      if(isWrapImg(editorBlocks[k])) j = k; else break;
    }
    const nx = editorBlocks[j + 1]; let at;
    if(!nx){ editorBlocks.push({type:'text', html:'<p><br></p>', clr:true}); at = j + 1; }
    else if(isEmptyText(nx)){ nx.clr = true; at = j + 1; }                   // blok kosong setelah foto dijadikan "di bawah foto"
    else { editorBlocks.splice(j + 2, 0, {type:'text', html:'<p><br></p>', clr:true}); at = j + 2; }   // teks di samping foto tetap, baris baru di bawahnya
    rerenderBlocks();
    const el = document.querySelector('#me_blocks .memo-editor-block[data-block="' + at + '"]');
    if(el){ el.focus(); const r = document.createRange(); r.selectNodeContents(el); r.collapse(true); const sel = getSelection(); sel.removeAllRanges(); sel.addRange(r); el.scrollIntoView({block:'nearest'}); }
  }));
  document.querySelectorAll('[data-imglay]').forEach(b=>b.addEventListener('click', ()=>{ const [i,v] = b.dataset.imglay.split(':'); editorBlocks[Number(i)].lay = v; rerenderBlocks(); }));
  document.querySelectorAll('[data-imgw]').forEach(b=>b.addEventListener('click', ()=>{ const [i,v] = b.dataset.imgw.split(':').map(Number); editorBlocks[i].w = v; rerenderBlocks(); }));
  document.querySelectorAll('[data-imgdel]').forEach(b=>b.addEventListener('click', ()=>{
    const i = Number(b.dataset.imgdel);
    editorBlocks.splice(i, 1); editorBlocks = mergeTextBlocks(editorBlocks);
    if(!editorBlocks.length) editorBlocks = [{type:'text', html:'<p></p>'}];
    rerenderBlocks();                                                     // bisa dibatalkan dengan Undo
  }));
  document.querySelectorAll('[data-chk]').forEach(cb=>cb.addEventListener('change', ()=>{ const [bi,ii]=cb.dataset.chk.split(':').map(Number); editorBlocks[bi].items[ii].done = cb.checked; memoCommit(); }));
  document.querySelectorAll('[data-chktxt]').forEach(inp=>{
    inp.addEventListener('input', ()=>{ const [bi,ii]=inp.dataset.chktxt.split(':').map(Number); editorBlocks[bi].items[ii].text = inp.value; });
    inp.addEventListener('keydown', e=>{
      const [bi,ii] = inp.dataset.chktxt.split(':').map(Number), items = editorBlocks[bi].items;
      if(e.key === 'Enter'){ e.preventDefault(); items.splice(ii+1, 0, {text:'', done:false}); rerenderBlocks(); const n = document.querySelector(`[data-chktxt="${bi}:${ii+1}"]`); if(n) n.focus(); }
      else if(e.key === 'Backspace' && !inp.value){ e.preventDefault(); if(items.length > 1) items.splice(ii, 1); else removeChecklistBlock(bi); rerenderBlocks(); const n = document.querySelector(`[data-chktxt="${bi}:${Math.max(0, ii-1)}"]`); if(n) n.focus(); }
    });
  });
  document.querySelectorAll('[data-chkdel]').forEach(b=>b.addEventListener('click', ()=>{ const [bi,ii]=b.dataset.chkdel.split(':').map(Number); editorBlocks[bi].items.splice(ii,1); if(!editorBlocks[bi].items.length) removeChecklistBlock(bi); rerenderBlocks(); }));
  document.querySelectorAll('[data-chkadd]').forEach(b=>b.addEventListener('click', ()=>{ const i=Number(b.dataset.chkadd); editorBlocks[i].items.push({text:'',done:false}); rerenderBlocks(); const n = document.querySelector(`[data-chktxt="${i}:${editorBlocks[i].items.length-1}"]`); if(n) n.focus(); }));
}

/* ---------------- Auto-simpan (Memo, Barang, Folder) ---------------- */
// Menyimpan otomatis ~1 detik setelah berhenti mengetik, saat pindah halaman, dan saat tab ditutup/disembunyikan.
// Hanya menulis bila isinya benar-benar berbeda dari yang tersimpan terakhir.
const autosavers = new Set();
// Kode unik untuk data BARU. Server memakainya agar permintaan "buat baru" yang terkirim dua kali (internet lambat, klik dua kali)
// tidak membuat dua baris di database.
const uuid = () => (window.crypto && crypto.randomUUID) ? crypto.randomUUID() : 'u' + Date.now().toString(36) + Math.random().toString(36).slice(2, 14);
function makeAutosave({store, id = null, original = null, build, delay = 1000, onState, uid = null}){
  const myUid = uid || uuid();
  let timer = null, q = Promise.resolve(), lastKey = null, saved = false, closed = false, failed = false, since = 0;
  const keyOf = o => JSON.stringify(o, (k, v) => (k === 'updatedAt' || k === 'id' || k === 'src') ? undefined : v);
  const api = {
    get id(){ return id; }, get active(){ return !closed; }, get failed(){ return failed; }, get changed(){ return saved; },
    baseline(){ const o = build(); lastKey = o ? keyOf(o) : null; },       // keadaan saat dibuka = "sudah tersimpan"
    dirty(){ if(saved) return true; const o = build(); return (o ? keyOf(o) : null) !== lastKey; },
    schedule(keep){
      if(closed) return;
      if(keep && timer) return;                                          // sudah terjadwal: jangan mundurkan tenggat
      const now = Date.now(); if(!since) since = now;
      clearTimeout(timer);
      if(now - since > 5000){ api.flush(); return; }                    // mengetik terus-menerus: tetap simpan tiap ±5 detik
      timer = setTimeout(()=>api.flush(), delay);
      if(onState) onState('pending');
    },
    flush(){
      clearTimeout(timer); timer = null; since = 0;
      if(closed) return q;
      const obj = build();
      if(!obj) return q;                                                 // belum layak disimpan (mis. masih kosong)
      const key = keyOf(obj);
      if(key === lastKey) return q;
      lastKey = key;
      q = q.then(async()=>{
        try{
          if(id !== null) obj.id = id; else obj.uid = myUid;
          id = await put(store, obj); saved = true; failed = false; markWrite();
          if(onState) onState('saved');
        }catch(e){ failed = true; lastKey = null; if(onState) onState('error'); }
      });
      return q;
    },
    async finish(){ await api.flush(); await q; if(failed) return false; closed = true; clearTimeout(timer); autosavers.delete(api); return true; },
    async discard(){ clearTimeout(timer); closed = true; autosavers.delete(api); await q; if(original) await put(store, original); else if(id !== null && saved) await del(store, id); },
    close(){ closed = true; clearTimeout(timer); autosavers.delete(api); }
  };
  autosavers.add(api);
  return api;
}
function flushAllAutosave(){ autosavers.forEach(a=>a.flush()); if(typeof editing !== 'undefined' && editing) sheetAutosave(); }
window.addEventListener('pagehide', flushAllAutosave);
document.addEventListener('visibilitychange', ()=>{ if(document.hidden) flushAllAutosave(); });

let memoAS = null, memoUid = null;      // memoUid: satu kode untuk SATU memo baru, dipakai bersama bila editor sempat tergambar dua kali
function leaveMemoEditor(){ memoAS = null; memoUid = null; view = 'memo'; activeMemoId = null; render(); }
function memoCollect(){ syncTextBlocksFromDOM(); }
function memoHasContent(title){
  if(title) return true;
  return editorBlocks.some(b=>b.type === 'table' || b.type === 'image' ||
    (b.type === 'checklist' && b.items.some(i=>i.text.trim())) ||
    (b.type === 'text' && b.html.replace(/<[^>]*>|&nbsp;/g, '').trim()));
}
function memoBuild(){
  const t = document.getElementById('me_title'), dt = document.getElementById('me_date');
  if(!t || !dt) return null;
  memoCollect();
  const title = t.value.trim();
  if(!memoHasContent(title)) return null;
  if(!editorCreatedAt) editorCreatedAt = Date.now();
  return { title, date: dt.value || todayISO(), blocks: JSON.parse(JSON.stringify(editorBlocks)),
           createdAt: editorCreatedAt, updatedAt: Date.now(), ...(editorFromSheet ? {fromSheet: editorFromSheet} : {}) };
}
function memoStatus(s){
  if(s === 'saved' && memoAS && activeMemoId === null && memoAS.id !== null) activeMemoId = memoAS.id;
  const el = document.getElementById('me_status'); if(!el) return;
  if(s === 'pending') el.textContent = 'Menyimpan otomatis…';
  else if(s === 'saved') el.textContent = '✓ Tersimpan otomatis ' + new Date().toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'});
  else if(s === 'error') el.textContent = '⚠ Gagal menyimpan otomatis';
}
// Rata teks: kiri / tengah / kanan untuk paragraf yang sedang dipilih (atau yang berisi kursor).
function applyMemoAlign(dir){
  const sel = window.getSelection();
  const hostOf = n => { const el = n && (n.nodeType === 1 ? n : n.parentElement); return el && el.closest ? el.closest('.memo-editor-block, .cellval[contenteditable]') : null; };
  let host = null, r = null;
  if(sel && sel.rangeCount){ r = sel.getRangeAt(0); host = hostOf(r.startContainer); if(host && hostOf(r.endContainer) !== host) host = null; }
  if(!host){ toast('Klik di dalam teks memo dulu, lalu pilih rata teks.'); return; }
  if(host.classList.contains('cellval')){   // sel tabel: rata teks lewat perintah editor (tersimpan di dalam isi sel)
    document.execCommand('styleWithCSS', false, true);
    document.execCommand({left:'justifyLeft', center:'justifyCenter', right:'justifyRight'}[dir]);
    memoCommit(); return;
  }
  const sc = r.startContainer, so = r.startOffset, ec = r.endContainer, eo = r.endOffset;
  const BLOCK = /^(P|DIV|UL|OL|H[1-6]|BLOCKQUOTE|PRE)$/;
  let run = [];
  const flushRun = ()=>{                                                  // bungkus teks lepas jadi paragraf agar bisa diratakan
    if(!run.length) return;
    if(run.some(n=>n.nodeType === 1 || n.textContent.trim() !== '')){ const p = document.createElement('p'); host.insertBefore(p, run[0]); run.forEach(n=>p.appendChild(n)); }
    run = [];
  };
  Array.from(host.childNodes).forEach(n=>{ if(n.nodeType === 1 && BLOCK.test(n.tagName)) flushRun(); else run.push(n); });
  flushRun();
  if(!host.firstElementChild){ host.innerHTML = '<p><br></p>'; }
  try{ const nr = document.createRange(); nr.setStart(sc, so); nr.setEnd(ec, eo); sel.removeAllRanges(); sel.addRange(nr); r = nr; }catch(e){ r = null; }
  const kids = Array.from(host.children);
  const direct = n => { while(n && n.parentNode !== host) n = n.parentNode; return n; };
  let i = -1, j = -1;
  if(r){
    let a = direct(r.startContainer), b = direct(r.endContainer);
    if(r.startContainer === host) a = host.childNodes[Math.min(r.startOffset, host.childNodes.length - 1)];
    if(r.endContainer === host) b = host.childNodes[Math.max(0, Math.min(r.endOffset - 1, host.childNodes.length - 1))];
    i = kids.indexOf(a); j = kids.indexOf(b);
  }
  if(i < 0 || j < 0){ i = 0; j = kids.length - 1; }
  if(i > j){ const t = i; i = j; j = t; }
  for(let k = i; k <= j; k++){
    const el = kids[k];
    el.style.textAlign = dir === 'left' ? '' : dir;
    if(!el.getAttribute('style')) el.removeAttribute('style');
  }
  memoCommit();                                                           // langkah riwayat + auto-simpan
}

/* ---------------- Undo / Redo ---------------- */
// Memo: satu riwayat per memo yang sedang dibuka (judul + semua blok: teks, tabel, checklist). Disimpan di memori
// selama editor terbuka. Tabel: satu riwayat per tabel (lihat sheetHist). Keduanya tidak pernah tercampur.
const HIST_MAX = 100;
const imgPool = new Map();   // id foto -> data URL (tidak ikut disalin ke setiap langkah Undo, supaya hemat memori)
let memoHist = {undo:[], redo:[], present:null, timer:null, pending:false, groupStart:0, applying:false};
function memoShot(){
  syncTextBlocksFromDOM();
  const t = document.getElementById('me_title');
  return JSON.stringify({title: t ? t.value : '', blocks: editorBlocks}, function(k, v){ return (k === 'src' && this && this.type === 'image') ? undefined : v; });
}
function memoHistReset(){ clearTimeout(memoHist.timer); memoHist = {undo:[], redo:[], present:memoShot(), timer:null, pending:false, groupStart:0, applying:false}; updateUndoButtons(); }
function memoCommit(){
  if(memoHist.applying) return;
  clearTimeout(memoHist.timer); memoHist.timer = null; memoHist.pending = false;
  const snap = memoShot();
  if(snap !== memoHist.present){
    memoHist.undo.push(memoHist.present); if(memoHist.undo.length > HIST_MAX) memoHist.undo.shift();
    memoHist.redo = []; memoHist.present = snap; if(memoAS) memoAS.schedule(true);      // perubahan baru setelah Undo -> riwayat Redo dibuang
  }
  updateUndoButtons();
}
function memoTyped(){   // ketikan berurutan digabung jadi satu langkah (jeda 600 ms, maksimal ±4 detik per grup)
  if(memoHist.applying) return;
  const now = Date.now();
  if(!memoHist.pending){ memoHist.pending = true; memoHist.groupStart = now; }
  clearTimeout(memoHist.timer);
  if(now - memoHist.groupStart > 4000){ memoCommit(); return; }
  memoHist.timer = setTimeout(memoCommit, 600); if(memoAS) memoAS.schedule();
  updateUndoButtons();
}
function focusEnd(el){
  try{ el.focus(); const r = document.createRange(); r.selectNodeContents(el); r.collapse(false); const s = window.getSelection(); s.removeAllRanges(); s.addRange(r); }catch(e){}
}
function memoStep(dir){
  memoCommit();                                  // ketikan yang masih menunggu ikut disimpan sebagai langkah dulu
  const from = dir === 'undo' ? memoHist.undo : memoHist.redo, to = dir === 'undo' ? memoHist.redo : memoHist.undo;
  if(!from.length) return;
  to.push(memoHist.present);
  const snap = from.pop(), o = JSON.parse(snap);
  memoHist.applying = true;
  try{
    o.blocks.forEach(b=>{ if(b.type === 'image') b.src = imgPool.get(b.id) || ''; });
    editorBlocks = o.blocks;
    const t = document.getElementById('me_title'); if(t) t.value = o.title;
    rerenderBlocks();
    memoHist.present = memoShot();               // bentuk yang sudah dinormalisasi DOM, supaya tidak terhitung sebagai perubahan baru
  } finally { memoHist.applying = false; }
  updateUndoButtons();
  const el = lastTextIdx !== null && editorBlocks[lastTextIdx] && editorBlocks[lastTextIdx].type === 'text'
    ? document.querySelector('.memo-editor-block[data-block="' + lastTextIdx + '"]') : null;
  if(el) focusEnd(el);
  if(memoAS) memoAS.schedule(true);
}
function updateUndoButtons(){
  const set = (id, off)=>{ const b = document.getElementById(id); if(b) b.disabled = off; };
  if(view === 'memo-editor'){ set('me_undo', !(memoHist.undo.length || memoHist.pending)); set('me_redo', !memoHist.redo.length); }
  else if(view === 'sheet'){ const h = shHist(activeSheetId); set('shUndo', !h.undo.length); set('shRedo', !h.redo.length); }
}
// Shortcut: Ctrl/Cmd+Z = Undo, Ctrl+Y atau Ctrl+Shift+Z = Redo. Hanya bekerja di area yang sedang aktif.
document.addEventListener('keydown', e=>{
  if(!(e.ctrlKey || e.metaKey) || e.altKey) return;
  const k = (e.key || '').toLowerCase();
  const act = k === 'z' ? (e.shiftKey ? 'redo' : 'undo') : (k === 'y' && !e.shiftKey ? 'redo' : null);
  if(!act || document.querySelector('.overlay')) return;     // ada dialog terbuka -> jangan ganggu
  const a = document.activeElement;
  if(view === 'memo-editor'){
    const inEditor = a === document.body || (a.closest && a.closest('#content'));
    if(!inEditor || (a.tagName === 'INPUT' && a.type === 'date')) return;
    if(a.tagName === 'INPUT' && a.closest('table.memo-table') && a.value !== a.defaultValue) return; // ketikan sel yang belum selesai: undo bawaan browser
    e.preventDefault(); memoStep(act);
  } else if(view === 'sheet'){
    if(a !== document.body && !(editing && a === editing.inp)) return;   // fokus di kolom cari / input lain -> biarkan
    if(editing && a === editing.inp && a.value !== editing.raw) return;  // ketikan sel yang belum selesai: undo bawaan browser
    e.preventDefault(); sheetStep(act);
  }
});
// Undo/Redo dari menu konteks, keyboard HP, atau gestur sistem pada editor memo
document.addEventListener('beforeinput', e=>{
  if(e.inputType !== 'historyUndo' && e.inputType !== 'historyRedo') return;
  const t = e.target;
  if(view !== 'memo-editor' || !t.closest || !t.closest('#content') || t.type === 'date') return;
  if(t.tagName === 'INPUT' && t.closest('table.memo-table') && t.value !== t.defaultValue) return;
  e.preventDefault(); memoStep(e.inputType === 'historyUndo' ? 'undo' : 'redo');
}, true);

// Klik di mana saja di luar kotak edit sel = simpan & tutup. Kalau yang diklik sel/header lain, klik itu diteruskan
// supaya tidak perlu klik dua kali. Klik di toolbar (B/I/U, Undo, dll.) dikecualikan: mereka menyimpan ketikan sendiri.
document.addEventListener('mousedown', e=>{
  if(view !== 'sheet' || !editing) return;
  const inp = editing.inp, tg = e.target;
  if(tg === inp || (inp.contains && inp.contains(tg)) || !tg.closest || tg.closest('.sheet-toolbar, .rtb, .tb-pop')) return;
  const c = tg.closest('td[data-key]'), h = tg.closest('th[data-colsel]'), r = tg.closest('td[data-rowsel]');
  const next = c ? 'td[data-key="' + c.dataset.key + '"] .cellval' : h ? 'th[data-colsel="' + h.dataset.colsel + '"]' : r ? 'td[data-rowsel="' + r.dataset.rowsel + '"]' : null;
  const shift = e.shiftKey;
  commitEdit(true).then(()=>{
    if(!next) return;
    const el = document.querySelector(next);
    if(el) el.dispatchEvent(new MouseEvent('click', {bubbles:true, cancelable:true, shiftKey:shift}));
  });
}, true);

/* ---------------- Impor CSV / PDF ke Memo ---------------- */
let lastTextIdx = null;
const userErr = m => Object.assign(new Error(m), {userMessage:m});

// Parser CSV: tanda kutip, koma/enter di dalam kutip, "" sebagai kutip, BOM, pemisah , ; atau tab, sel kosong.
function parseCSV(text){
  if(text.charCodeAt(0) === 0xFEFF) text = text.slice(1);
  const counts = {',':0, ';':0, '\t':0}; let q = false;
  for(const ch of text){
    if(ch === '"') q = !q;
    else if(!q && (ch === '\n' || ch === '\r')) break;
    else if(!q && ch in counts) counts[ch]++;
  }
  const best = Object.keys(counts).sort((a,b)=>counts[b]-counts[a])[0];
  const sep = counts[best] > 0 ? best : ',';
  const rows = []; let row = [], field = '', inQ = false, any = false, i = 0;
  while(i < text.length){
    const ch = text[i];
    if(inQ){
      if(ch === '"'){ if(text[i+1] === '"'){ field += '"'; i += 2; continue; } inQ = false; i++; continue; }
      field += ch; i++; continue;
    }
    if(ch === '"' && field === ''){ inQ = true; any = true; i++; continue; }
    if(ch === sep){ row.push(field); field = ''; any = true; i++; continue; }
    if(ch === '\r' || ch === '\n'){
      if(ch === '\r' && text[i+1] === '\n') i++;
      row.push(field); field = ''; i++;
      if(any || row.length > 1 || row[0] !== '') rows.push(row);
      row = []; any = false; continue;
    }
    field += ch; any = true; i++;
  }
  if(any || field !== '' || row.length){ row.push(field); rows.push(row); }
  while(rows.length && rows[rows.length-1].every(c=>c.trim() === '')) rows.pop();
  return rows;
}
async function decodeTextFile(file){
  const buf = await file.arrayBuffer();
  try{ return new TextDecoder('utf-8', {fatal:true}).decode(buf); }       // UTF-8 (huruf Indonesia aman)
  catch(e){ return new TextDecoder('windows-1252').decode(buf); }          // CSV lama dari Excel Windows
}
async function csvFileToBlocks(file){
  let rows = parseCSV(await decodeTextFile(file));
  if(!rows.length) throw userErr('File CSV kosong atau tidak berisi data.');
  if(rows.length > 1001){ rows = rows.slice(0, 1001); toast('CSV sangat panjang, hanya 1000 baris pertama yang diimpor.', 5000); }
  const cols = Math.max(...rows.map(r=>r.length));
  rows = rows.map(r=>{ const x = r.slice(); while(x.length < cols) x.push(''); return x; });
  return [{type:'table', header: rows[0], rows: rows.length > 1 ? rows.slice(1) : [Array(cols).fill('')]}];
}

function loadPdfJs(){
  if(window.pdfjsLib) return Promise.resolve(window.pdfjsLib);
  return new Promise((res, rej)=>{
    const s = document.createElement('script');
    s.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js';
    s.onload = ()=>{
      if(!window.pdfjsLib) return rej(new Error('pdfjs'));
      window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
      res(window.pdfjsLib);
    };
    s.onerror = ()=>rej(new Error('load'));
    document.head.appendChild(s);
  });
}
// Kolom tabel = rentang x yang saling tumpang-tindih di baris-baris bercelah lebar.
function pdfColumns(lines){
  const iv = [];
  lines.filter(l=>l.cells.length >= 2).forEach(l=>l.cells.forEach(c=>iv.push({a:c.x, b:c.end})));
  iv.sort((p,q)=>p.a-q.a);
  const cols = [];
  for(const v of iv){ const c = cols[cols.length-1]; if(c && v.a <= c.b + 1) c.b = Math.max(c.b, v.b); else cols.push({a:v.a, b:v.b}); }
  return cols;
}
function pdfLinesToTable(lines){
  const cols = pdfColumns(lines);
  if(cols.length < 2 || lines.length < 2) return null;
  const rows = lines.map(l=>{
    const row = Array(cols.length).fill('');
    l.cells.forEach(c=>{
      const mid = (c.x + c.end) / 2; let best = 0, bd = Infinity;
      cols.forEach((k,i)=>{ const d = (mid >= k.a && mid <= k.b) ? 0 : Math.min(Math.abs(mid-k.a), Math.abs(mid-k.b)); if(d < bd){ bd = d; best = i; } });
      row[best] = row[best] ? row[best] + ' ' + c.s : c.s;
    });
    return row;
  });
  return {type:'table', header: rows[0], rows: rows.slice(1)};
}
// items: [{s, x, y, w, h}] satu halaman PDF -> blok memo (text / table)
function pdfItemsToBlocks(items){
  items = items.filter(i=>i.s.trim() !== '');
  if(!items.length) return [];
  items.sort((a,b)=>(b.y - a.y) || (a.x - b.x));
  const lines = [];
  for(const it of items){
    const ln = lines[lines.length-1];
    if(ln && Math.abs(ln.y - it.y) <= Math.max(2, ln.h * 0.4)){ ln.items.push(it); ln.h = Math.max(ln.h, it.h); }
    else lines.push({y:it.y, h:it.h, items:[it]});
  }
  lines.forEach(l=>{
    l.items.sort((a,b)=>a.x - b.x);
    l.cells = [];
    for(const it of l.items){
      const c = l.cells[l.cells.length-1];
      const gap = c ? it.x - c.end : 0;
      if(!c || gap > Math.max(3, l.h * 0.5)) l.cells.push({s:it.s, x:it.x, end:it.x + it.w});
      else { c.s = (c.s + (gap > l.h * 0.12 ? ' ' : '') + it.s); c.end = Math.max(c.end, it.x + it.w); }
    }
    l.cells.forEach(c=>{ c.s = c.s.replace(/\s+/g, ' ').trim(); });
  });
  const out = []; let para = null, run = null, prev = null;
  const flushPara = ()=>{ if(para){ out.push({type:'text', html:'<p>' + para.map(esc).join('<br>') + '</p>'}); para = null; } };
  const flushRun = ()=>{
    if(!run) return;
    const t = pdfLinesToTable(run);
    if(t) out.push(t);
    else out.push({type:'text', html: run.map(l=>'<p>' + l.cells.map(c=>esc(c.s)).join('&nbsp;&nbsp;&nbsp;') + '</p>').join('')});
    run = null;
  };
  for(const l of lines){
    const absorb = run && l.cells.length === 1 && l.cells[0].s.length <= 15 &&
      pdfColumns(run).some(k=>l.cells[0].x >= k.a - 3 && l.cells[0].x <= k.b + 3);
    if(l.cells.length >= 2 || absorb){ flushPara(); if(!run) run = []; run.push(l); }
    else {
      flushRun();
      if(para && prev && (prev.y - l.y) > l.h * 1.9) flushPara();
      if(!para) para = [];
      para.push(l.cells.map(c=>c.s).join(' '));
    }
    prev = l;
  }
  flushPara(); flushRun();
  return out;
}
function mergeTextBlocks(blocks){
  const out = [];
  for(const b of blocks){ const l = out[out.length-1]; if(b.type === 'text' && l && l.type === 'text') l.html += b.html; else out.push(b); }
  return out;
}
async function pdfFileToBlocks(file){
  let lib;
  try{ lib = await loadPdfJs(); }catch(e){ throw userErr('Pembaca PDF gagal dimuat. Impor PDF butuh koneksi internet saat pertama kali dipakai.'); }
  const data = new Uint8Array(await file.arrayBuffer());
  let pdf;
  try{ pdf = await lib.getDocument({data}).promise; }
  catch(e){
    if(e && e.name === 'PasswordException') throw userErr('PDF ini dilindungi password, jadi tidak bisa dibaca.');
    throw userErr('File PDF rusak atau tidak valid.');
  }
  const maxPages = Math.min(pdf.numPages, 30);
  const blocks = []; let chars = 0;
  for(let p = 1; p <= maxPages; p++){
    const page = await pdf.getPage(p);
    const tc = await page.getTextContent();
    const items = tc.items.filter(i=>typeof i.str === 'string')
      .map(i=>({s:i.str, x:i.transform[4], y:i.transform[5], w:i.width, h:i.height || Math.abs(i.transform[3]) || 10}));
    items.forEach(i=>{ chars += i.s.trim().length; });
    blocks.push(...pdfItemsToBlocks(items));
  }
  if(chars < 10) throw userErr('PDF ini sepertinya hasil scan/gambar (tidak ada teks yang bisa dibaca). Perlu OCR, dan itu belum didukung.');
  if(pdf.numPages > maxPages) toast('PDF panjang, hanya ' + maxPages + ' halaman pertama yang diimpor.', 5000);
  return mergeTextBlocks(blocks);
}

function insertImportedBlocks(blocks, fname, ins){
  const t = document.getElementById('me_title');
  if(t && !t.value.trim()) t.value = fname.replace(/\.[^.]+$/, '');
  applyInsert(ins || prepareInsert(), blocks, 'import');          // hanya menambah di posisi kursor; isi memo yang sudah ada tidak dihapus
}
let importIns = null;
async function importFileToMemo(file){
  const name = file.name || 'file';
  const ext = (name.split('.').pop() || '').toLowerCase();
  const isCsv = ext === 'csv' || file.type === 'text/csv';
  const isPdf = ext === 'pdf' || file.type === 'application/pdf';
  if(!isCsv && !isPdf){ toast('Format tidak didukung. Pilih file .csv atau .pdf.', 5000); return; }
  if(!file.size){ toast('File kosong, tidak ada yang bisa diimpor.', 5000); return; }
  if(isCsv && file.size > 5*1024*1024){ toast('File CSV terlalu besar (maksimal 5 MB).', 5000); return; }
  if(isPdf && file.size > 15*1024*1024){ toast('File PDF terlalu besar (maksimal 15 MB).', 5000); return; }
  toast('Membaca ' + name + '…');
  try{
    const blocks = isCsv ? await csvFileToBlocks(file) : await pdfFileToBlocks(file);
    if(!blocks.length) throw userErr('Tidak ada isi yang bisa diambil dari file ini.');
    insertImportedBlocks(blocks, name, importIns); importIns = null;
    toast('Berhasil mengimpor ' + name);
  }catch(err){ toast(err && err.userMessage ? err.userMessage : 'Gagal membaca file. Pastikan file tidak rusak.', 5000); }
}

function memoToolbarHTML(){
  const b = (cls, attrs, inner)=>`<button type="button" class="tb ${cls}" ${attrs}>${inner}</button>`;
  return `<div class="rtb stick${tbOpen.memo?' tb-open':''}" id="me_tb">
    ${b('', 'id="me_undo" title="Undo (Ctrl+Z)" aria-label="Undo" disabled', IC.undo)}
    ${b('', 'id="me_redo" title="Redo (Ctrl+Y / Ctrl+Shift+Z)" aria-label="Redo" disabled', IC.redo)}
    <span class="tb-sep tb-x"></span>
    ${b('wide tb-x', 'id="me_style" title="Gaya teks: judul, subjudul, teks biasa"', '<span id="me_stylelbl">Teks biasa</span><span>▾</span>')}
    ${b('wide tb-x', 'id="me_font" title="Jenis font"', '<span id="me_fontlbl">Inter</span><span>▾</span>')}
    <span class="tb-size tb-x">${b('', 'id="me_fsdown" title="Kecilkan font"', '−')}${b('num', 'id="me_fsval" title="Ukuran font"', '15')}${b('', 'id="me_fsup" title="Besarkan font"', '+')}</span>
    <span class="tb-sep"></span>
    ${b('', 'data-cmd="bold" title="Tebal (Ctrl+B)"', '<b>B</b>')}
    ${b('', 'data-cmd="italic" title="Miring (Ctrl+I)"', '<i>I</i>')}
    ${b('', 'data-cmd="underline" title="Garis bawah (Ctrl+U)"', '<u>U</u>')}
    ${b('tb-x', 'data-cmd="strikeThrough" title="Coret"', '<s>S</s>')}
    ${b('tb-color', 'id="me_color" title="Warna teks" aria-label="Warna teks"', '<span style="font-weight:700;line-height:1">A</span><span class="bar" id="me_colorbar" style="background:var(--ink)"></span>')}
    ${b('tb-color tb-x', 'id="me_hl" title="Warna sorotan teks" aria-label="Warna sorotan teks"', IC.fill + '<span class="bar" id="me_hlbar" style="background:#facc15"></span>')}
    <span class="tb-sep tb-x"></span>
    ${b('tb-x', 'data-align="left" title="Rata kiri" aria-label="Rata kiri"', IC.alL)}
    ${b('tb-x', 'data-align="center" title="Rata tengah" aria-label="Rata tengah"', IC.alC)}
    ${b('tb-x', 'data-align="right" title="Rata kanan" aria-label="Rata kanan"', IC.alR)}
    <span class="tb-sep"></span>
    ${b('', 'data-cmd="insertUnorderedList" title="Daftar berpoin" aria-label="Daftar berpoin"', IC.bullet)}
    ${b('', 'data-cmd="insertOrderedList" title="Daftar bernomor" aria-label="Daftar bernomor"', IC.numbered)}
    ${b('', 'id="me_addchk" title="Sisipkan checklist" aria-label="Checklist"', IC.check)}
    ${b('', 'id="me_table" title="Sisipkan tabel di posisi kursor" aria-label="Sisipkan tabel"', IC.table + '<span>Tabel</span>')}
    ${b('', 'id="me_photo" title="Sisipkan foto di posisi kursor" aria-label="Sisipkan foto"', IC.image + '<span>Foto</span>')}
    ${b('', 'id="me_photo_wrap" title="Sisipkan foto dengan teks di sebelahnya" aria-label="Foto dan teks"', IC.image + '<span>Foto+teks</span>')}
    ${b('tb-x', 'id="me_import" title="Impor file CSV atau PDF ke memo ini (isi yang sudah ada tidak dihapus)"', '📥 Impor')}
    ${b('tb-more', 'id="tbMoreM" title="Menu format lainnya" aria-label="Menu format lainnya"', '⋯')}
    <input type="file" id="me_file" accept=".csv,.pdf,text/csv,application/pdf" style="display:none">
    <input type="file" id="me_photo_file" accept="image/*" multiple style="display:none">
  </div>`;
}
/* ---- Perintah format Memo: hanya bekerja pada teks yang dipilih (atau mulai dari kursor), tidak mengubah seluruh memo ---- */
let memoPendingSize = null;
function memoSelHost(){
  const s = window.getSelection(); if(!s || !s.rangeCount) return null;
  const n = s.anchorNode, el = n && (n.nodeType === 1 ? n : n.parentElement);
  return el && el.closest ? el.closest('#me_blocks .memo-editor-block, #me_blocks .cellval[contenteditable]') : null;
}
function memoNeedSel(){ const h = memoSelHost(); if(!h) toast('Klik di dalam teks memo dulu, lalu pilih format.'); return h; }
// Penanda warna "otomatis": dipasang sebagai warna khusus lalu dibuang, supaya teks kembali ikut tema.
const SENT_FORE = '#010203', SENT_BACK = '#010204';
function fixFonts(){
  const root = document.getElementById('me_blocks'); if(!root) return;
  root.querySelectorAll('font[size="7"]').forEach(f=>{
    const sp = document.createElement('span'); sp.style.fontSize = (memoPendingSize || 15) + 'px';
    while(f.firstChild) sp.appendChild(f.firstChild); f.replaceWith(sp);
  });
  root.querySelectorAll('[style]').forEach(el=>{
    if(el.style.color === 'rgb(1, 2, 3)') el.style.color = '';
    if(el.style.backgroundColor === 'rgb(1, 2, 4)') el.style.backgroundColor = '';
    if(!el.getAttribute('style')) el.removeAttribute('style');
  });
}
function tidySpans(){
  const root = document.getElementById('me_blocks'); if(!root) return;
  root.querySelectorAll('span').forEach(sp=>{ if(!sp.attributes.length){ while(sp.firstChild) sp.parentNode.insertBefore(sp.firstChild, sp); sp.remove(); } });
}
function memoExec(cmd, val){
  if(!memoNeedSel()) return false;
  const css = ['foreColor','hiliteColor','backColor','fontName'].includes(cmd);
  document.execCommand('styleWithCSS', false, css);
  const ok = document.execCommand(cmd, false, val == null ? null : val);
  fixFonts(); tidySpans(); memoCommit(); memoToolbarState();
  return ok;
}
function memoColor(kind, c){
  if(!memoNeedSel()) return;
  memoExec(kind === 'fore' ? 'foreColor' : 'hiliteColor', c || (kind === 'fore' ? SENT_FORE : SENT_BACK));
  const bar = document.getElementById(kind === 'fore' ? 'me_colorbar' : 'me_hlbar');
  if(bar && c) bar.style.background = c;
}
function memoFont(name){ memoExec('fontName', name); }
function memoSetSize(px){
  if(!memoNeedSel()) return;
  memoPendingSize = px;
  document.execCommand('styleWithCSS', false, false);
  document.execCommand('fontSize', false, '7');
  fixFonts(); tidySpans(); memoCommit(); memoToolbarState();
}
function memoStepSize(dir){
  const cur = Number((document.getElementById('me_fsval') || {}).textContent) || 15; let i;
  if(dir > 0){ i = FONT_SIZES.findIndex(x=>x > cur); if(i < 0) i = FONT_SIZES.length - 1; }
  else { i = -1; FONT_SIZES.forEach((x,j)=>{ if(x < cur) i = j; }); if(i < 0) i = 0; }
  memoSetSize(FONT_SIZES[i]);
}
function memoBlockStyle(v){
  const h = memoNeedSel(); if(!h) return;
  if(!h.classList.contains('memo-editor-block')){ toast('Gaya judul hanya untuk teks di luar tabel.'); return; }
  document.execCommand('formatBlock', false, '<' + v + '>');
  fixFonts(); memoCommit(); memoToolbarState();
}
function memoToolbarState(){
  const tb = document.getElementById('me_tb'); if(!tb || view !== 'memo-editor') return;
  const host = memoSelHost(); if(!host) return;
  const on = (sel, v)=>{ const b = tb.querySelector(sel); if(b) b.classList.toggle('on', !!v); };
  ['bold','italic','underline','strikeThrough','insertUnorderedList','insertOrderedList'].forEach(c=>{ let v = false; try{ v = document.queryCommandState(c); }catch(e){} on('[data-cmd="' + c + '"]', v); });
  const n = window.getSelection().anchorNode, el = n.nodeType === 1 ? n : n.parentElement, cs = getComputedStyle(el);
  const q = id => document.getElementById(id);
  q('me_fsval').textContent = Math.round(parseFloat(cs.fontSize)) || 15;
  q('me_fontlbl').textContent = (cs.fontFamily.split(',')[0] || 'Inter').replace(/["']/g, '').trim();
  const hb = el.closest('h1,h2'); q('me_stylelbl').textContent = hb ? (hb.tagName === 'H1' ? 'Judul' : 'Subjudul') : 'Teks biasa';
  const al = host.classList.contains('cellval') ? '' : (el.closest('p,div,h1,h2,li') || {style:{}}).style.textAlign;
  tb.querySelectorAll('[data-align]').forEach(b=>b.classList.toggle('on', (al || 'left') === b.dataset.align && !host.classList.contains('cellval')));
}
document.addEventListener('selectionchange', ()=>{ if(view === 'memo-editor') memoToolbarState(); });

// Foto diperkecil (sisi terpanjang maks. 1600 px) dan disimpan sebagai JPEG supaya penyimpanan lokal tetap ringan.
// Foto sel dipakai berulang tiap tabel digambar ulang: ubah sekali ke URL blob supaya HTML kecil dan gambar tidak didekode ulang.
const imgUrlCache = new Map();
function imgUrl(id, dataUrl){
  let u = imgUrlCache.get(id); if(u) return u;
  try{
    const [h, b] = dataUrl.split(','), mime = (h.match(/:(.*?);/) || [])[1] || 'image/jpeg', bin = atob(b), arr = new Uint8Array(bin.length);
    for(let i = 0; i < bin.length; i++) arr[i] = bin.charCodeAt(i);
    u = URL.createObjectURL(new Blob([arr], {type:mime}));
  }catch(e){ u = dataUrl; }
  imgUrlCache.set(id, u); return u;
}
function photoToDataUrl(file, maxPx, quality){
  return new Promise((res, rej)=>{
    const fr = new FileReader();
    fr.onerror = ()=>rej(new Error('read'));
    fr.onload = ()=>{
      const img = new Image();
      img.onerror = ()=>rej(new Error('img'));
      img.onload = ()=>{
        const k = Math.min(1, (maxPx || 1600) / Math.max(img.naturalWidth, img.naturalHeight)), w = Math.max(1, Math.round(img.naturalWidth * k)), h = Math.max(1, Math.round(img.naturalHeight * k));
        const cv = document.createElement('canvas'); cv.width = w; cv.height = h;
        const cx = cv.getContext('2d'); cx.fillStyle = '#fff'; cx.fillRect(0, 0, w, h); cx.drawImage(img, 0, 0, w, h);
        res(cv.toDataURL('image/jpeg', quality || 0.85));
      };
      img.src = fr.result;
    };
    fr.readAsDataURL(file);
  });
}
function openTableDialog(){
  const ins = prepareInsert();
  document.body.insertAdjacentHTML('beforeend', `<div class="overlay" id="ovTbl"><div class="modal">
    <h3>Sisipkan Tabel</h3>
    <div class="field-row">
      <div class="field"><label>Jumlah baris</label><input id="tb_r" type="number" min="1" max="50" value="3"></div>
      <div class="field"><label>Jumlah kolom</label><input id="tb_c" type="number" min="1" max="20" value="3"></div>
    </div>
    <div style="font-size:.78rem;color:var(--muted);">Tabel disisipkan di posisi kursor. Kamu tetap bisa mengetik di atas dan di bawahnya.</div>
    <div class="modal-actions"><button class="btn ghost" id="tbAnc">Batal</button><button class="btn" id="tbOk">Sisipkan</button></div>
  </div></div>`);
  const close = ()=>{ const o = document.getElementById('ovTbl'); if(o) o.remove(); };
  const go = ()=>{
    const r = Math.max(1, Math.min(50, parseInt(document.getElementById('tb_r').value) || 3)), c = Math.max(1, Math.min(20, parseInt(document.getElementById('tb_c').value) || 3));
    close();
    applyInsert(ins, [{type:'table', header:Array.from({length:c}, (_,i)=>colLetter(i)), rows:Array.from({length:r}, ()=>Array(c).fill('')), rich:true}], 'table');
  };
  document.getElementById('tbAnc').onclick = close; document.getElementById('tbOk').onclick = go;
  ['tb_r','tb_c'].forEach(id=>document.getElementById(id).addEventListener('keydown', e=>{ if(e.key === 'Enter') go(); }));
  document.getElementById('tb_r').focus(); document.getElementById('tb_r').select();
}
function wireMemoToolbar(){
  const $ = id => document.getElementById(id), tb = $('me_tb');
  tb.querySelectorAll('button').forEach(b=>b.addEventListener('mousedown', e=>e.preventDefault()));   // pertahankan kursor & seleksi di editor
  tb.addEventListener('click', ()=>{ if(memoHist.pending) memoCommit(); }, true);                      // ketikan sebelum klik = langkah Undo tersendiri
  $('tbMoreM').addEventListener('click', ()=>{ tbOpen.memo = !tbOpen.memo; tb.classList.toggle('tb-open', tbOpen.memo); });
  $('me_undo').addEventListener('click', ()=>memoStep('undo'));
  $('me_redo').addEventListener('click', ()=>memoStep('redo'));
  tb.querySelectorAll('[data-cmd]').forEach(b=>b.addEventListener('click', ()=>memoExec(b.dataset.cmd)));
  tb.querySelectorAll('[data-align]').forEach(b=>b.addEventListener('click', ()=>applyMemoAlign(b.dataset.align)));
  $('me_style').addEventListener('click', ()=>menuPop($('me_style'), [
    {v:'p', label:'Teks biasa'},
    {v:'h1', html:'<span style="font-family:\'Plus Jakarta Sans\',sans-serif;font-size:1.35rem;font-weight:800">Judul</span>'},
    {v:'h2', html:'<span style="font-family:\'Plus Jakarta Sans\',sans-serif;font-size:1.1rem;font-weight:700">Subjudul</span>'}], null, v=>memoBlockStyle(v)));
  $('me_font').addEventListener('click', ()=>menuPop($('me_font'), FONTS.map(f=>({v:f, label:f, style:`font-family:'${f}',sans-serif`})), null, f=>memoFont(f)));
  $('me_fsval').addEventListener('click', ()=>menuPop($('me_fsval'), FONT_SIZES.map(x=>({v:x, label:String(x)})), null, x=>memoSetSize(x)));
  $('me_fsdown').addEventListener('click', ()=>memoStepSize(-1));
  $('me_fsup').addEventListener('click', ()=>memoStepSize(1));
  $('me_color').addEventListener('click', ()=>colorPop($('me_color'), c=>memoColor('fore', c), 'Otomatis (ikut tema)'));
  $('me_hl').addEventListener('click', ()=>colorPop($('me_hl'), c=>memoColor('back', c), 'Tanpa sorotan'));
  $('me_addchk').addEventListener('click', ()=>applyInsert(prepareInsert(), [{type:'checklist', items:[{text:'', done:false}]}], 'chk'));
  $('me_table').addEventListener('click', openTableDialog);
  const photoIn = $('me_photo');
  let photoIns = null;
  let photoLay = 'l';
  photoIn.addEventListener('click', ()=>{ photoIns = prepareInsert(); photoLay = 'l'; $('me_photo_file').click(); });
  $('me_photo_wrap').addEventListener('click', ()=>{ photoIns = prepareInsert(); photoLay = 'wl'; $('me_photo_file').click(); });   // foto di kiri, teks mengalir di kanannya
  $('me_photo_file').addEventListener('change', async e=>{
    const files = [...e.target.files]; e.target.value = ''; if(!files.length) return;
    toast('Memproses foto…');
    const blocks = []; let bad = 0;
    for(const f of files){
      if(!/^image\//.test(f.type) || f.size > 25*1024*1024){ bad++; continue; }
      try{ blocks.push({type:'image', id:'img' + Math.random().toString(36).slice(2), src: await photoToDataUrl(f, 1100, 0.78), w: photoLay === 'wl' ? 40 : 66, lay: photoLay}); }catch(err){ bad++; }
    }
    blocks.forEach(b=>imgPool.set(b.id, b.src));
    if(blocks.length){ applyInsert(photoIns || prepareInsert(), blocks, 'import'); toast(blocks.length + ' foto disisipkan' + (bad ? ` (${bad} file dilewati)` : '')); }
    else toast('Foto tidak bisa dibaca. Pilih file gambar (JPG/PNG/WebP), maksimal 25 MB.', 4500);
    photoIns = null;
  });
  const fileIn = $('me_file');
  $('me_import').addEventListener('click', ()=>{ importIns = prepareInsert(); fileIn.click(); });
  fileIn.addEventListener('change', async ()=>{ const f = fileIn.files[0]; fileIn.value = ''; if(f) await importFileToMemo(f); });
}
function wireMemoEditor(){
  wireBlockInteractions();
  document.getElementById('backToMemoList').addEventListener('click', async ()=>{ if(memoAS){ await memoAS.flush(); memoAS.close(); } leaveMemoEditor(); });
  document.getElementById('me_cancel').addEventListener('click', ()=>{
    if(!memoAS || !memoAS.dirty()){ if(memoAS) memoAS.close(); leaveMemoEditor(); return; }
    confirmModal('Buang perubahan?', editorOriginal ? 'Perubahan pada memo ini akan dibatalkan dan isinya kembali seperti saat dibuka.' : 'Memo baru ini tidak akan disimpan.', async()=>{ await memoAS.discard(); leaveMemoEditor(); }, null, 'Buang');
  });
  attachAutoCapitalize(document.getElementById('me_title'));
  // --- Undo / Redo memo ---
  memoHistReset();
  if(memoAS) memoAS.close();                                         // editor tergambar ulang: autosave lama jangan ikut menyimpan (bisa membuat memo dobel)
  if(activeMemoId === null && !memoUid) memoUid = uuid();
  memoAS = makeAutosave({store:'memos', id:activeMemoId, original:editorOriginal, build:memoBuild, onState:memoStatus, uid:activeMemoId === null ? memoUid : null});
  if(editorIsDraft) memoAS.flush(); else memoAS.baseline();    // salinan dari tabel langsung tersimpan; memo lain menunggu ada perubahan
  document.getElementById('me_date').addEventListener('change', ()=>{ if(memoAS) memoAS.schedule(); });
  const blocks = document.getElementById('me_blocks');
  blocks.addEventListener('click', ()=>{ if(memoHist.pending) memoCommit(); }, true);   // ketikan sebelum klik = langkah tersendiri
  blocks.addEventListener('input', e=>{ autoList(e); fixFonts(); memoTyped(); });
  document.getElementById('me_title').addEventListener('input', ()=>memoTyped());
  blocks.addEventListener('focusin', e=>{
    const t = e.target.closest ? e.target : null; if(!t) return;
    const b = t.closest('.memo-editor-block'); if(b) lastTextIdx = Number(b.dataset.block);
    const d = t.closest('.cellval[data-b]');
    if(d) lastCell = {b:Number(d.dataset.b), r: d.dataset.r != null ? Number(d.dataset.r) : -1, c: Number(d.dataset.c != null ? d.dataset.c : d.dataset.h)};
  });
  blocks.addEventListener('click', e=>{          // klik area kosong di halaman = kursor ke akhir teks terakhir
    if(e.target !== blocks) return;
    for(let i = editorBlocks.length - 1; i >= 0; i--) if(editorBlocks[i].type === 'text'){ const el = blocks.querySelector('.memo-editor-block[data-block="' + i + '"]'); if(el) focusEnd(el); break; }
  });
  wireMemoToolbar();

  document.getElementById('me_save').addEventListener('click', async ()=>{
    const title = document.getElementById('me_title').value.trim();
    if(!title){ toast('Judul wajib diisi'); return; }
    if(!document.getElementById('me_date').value){ toast('Tanggal wajib diisi'); return; }
    const ok = memoAS ? await memoAS.finish() : false;
    if(!ok){ toast('Gagal menyimpan memo'); return; }
    toast('Memo berhasil disimpan');
    await logActivity(editorOriginal ? 'edit' : 'add', 'memo', title);
    leaveMemoEditor();
  });
}

/* ---------------- Tabel (spreadsheet) ---------------- */
function colLetter(idx){ let s='',n=idx+1; while(n>0){ const m=(n-1)%26; s=String.fromCharCode(65+m)+s; n=Math.floor((n-1)/26);} return s; }
function colIndex(letters){ let n=0; for(const ch of letters) n = n*26 + (ch.charCodeAt(0)-64); return n-1; }
function cellKey(r,c){ return r+'_'+c; }
function rangeValues(sheet, c1, r1, c2, r2, cache, stack){
  const cA=colIndex(c1), cB=colIndex(c2), rA=parseInt(r1)-1, rB=parseInt(r2)-1;
  const vals=[];
  for(let rr=Math.min(rA,rB); rr<=Math.max(rA,rB); rr++)
    for(let cc=Math.min(cA,cB); cc<=Math.max(cA,cB); cc++)
      { const kk = cellKey(rr,cc), nn = toNum(evalCell(sheet, kk, cache, stack), !!(sheet.fmt && sheet.fmt[kk] && sheet.fmt[kk].nf === 'rupiah')); if(isFinite(nn)) vals.push(nn); }   // sel kosong / teks diabaikan (seperti Google Sheets)
  return vals;
}

function rangeRaw(sheet, c1, r1, c2, r2, cache, stack){
  const cA=colIndex(c1), cB=colIndex(c2), rA=parseInt(r1)-1, rB=parseInt(r2)-1, out=[];
  for(let rr=Math.min(rA,rB); rr<=Math.max(rA,rB); rr++)
    for(let cc=Math.min(cA,cB); cc<=Math.max(cA,cB); cc++){
      const k = cellKey(rr,cc); out.push({v: evalCell(sheet, k, cache, stack), rp: !!(sheet.fmt && sheet.fmt[k] && sheet.fmt[k].nf === 'rupiah')});
    }
  return out;
}
function evalCell(sheet, key, cache, stack){
  if(cache.has(key)) return cache.get(key);
  if(stack.has(key)) return 0;
  const raw = (sheet.cells && sheet.cells[key]) || '';
  let val;
  if(typeof raw === 'string' && raw.startsWith('=')){
    stack.add(key);
    let expr = raw.slice(1).toUpperCase();
    expr = expr.replace(/SUM\(([A-Z]+)(\d+):([A-Z]+)(\d+)\)/g, (m,c1,r1,c2,r2)=>'('+String(rangeValues(sheet,c1,r1,c2,r2,cache,stack).reduce((a,b)=>a+b,0))+')');
    expr = expr.replace(/AVERAGE\(([A-Z]+)(\d+):([A-Z]+)(\d+)\)/g, (m,c1,r1,c2,r2)=>{ const v=rangeValues(sheet,c1,r1,c2,r2,cache,stack); return '('+String(v.length? v.reduce((a,b)=>a+b,0)/v.length : 0)+')'; });
    expr = expr.replace(/MIN\(([A-Z]+)(\d+):([A-Z]+)(\d+)\)/g, (m,c1,r1,c2,r2)=>{ const v=rangeValues(sheet,c1,r1,c2,r2,cache,stack); return '('+String(v.length?Math.min(...v):0)+')'; });
    expr = expr.replace(/MAX\(([A-Z]+)(\d+):([A-Z]+)(\d+)\)/g, (m,c1,r1,c2,r2)=>{ const v=rangeValues(sheet,c1,r1,c2,r2,cache,stack); return '('+String(v.length?Math.max(...v):0)+')'; });
    expr = expr.replace(/(COUNTA|COUNT|MEDIAN|PRODUCT)\(([A-Z]+)(\d+):([A-Z]+)(\d+)\)/g, (m,fn,c1,r1,c2,r2)=>{
      const raws = rangeRaw(sheet,c1,r1,c2,r2,cache,stack), nums = raws.map(x=>toNum(x.v, x.rp)).filter(isFinite);
      let out;
      if(fn === 'COUNTA') out = raws.filter(x=>String(x.v) !== '').length;
      else if(fn === 'COUNT') out = nums.length;
      else if(fn === 'PRODUCT') out = nums.length ? nums.reduce((a,b)=>a*b, 1) : 0;
      else { const t = nums.slice().sort((a,b)=>a-b), h = Math.floor(t.length/2); out = !t.length ? 0 : (t.length % 2 ? t[h] : (t[h-1] + t[h]) / 2); }
      return '(' + out + ')';
    });
    expr = expr.replace(/\b([A-Z]+)(\d+)\b/g, (m,col,row)=>{
      const kk = cellKey(parseInt(row)-1, colIndex(col));
      const v = evalCell(sheet, kk, cache, stack);
      const n = toNum(v, !!(sheet.fmt && sheet.fmt[kk] && sheet.fmt[kk].nf === 'rupiah')); return isFinite(n) ? '(' + String(n) + ')' : '(0)';
    });
    stack.delete(key);
    if(!/^[0-9+\-*/().\s]*$/.test(expr) || !expr.trim()){ val = '#ERR'; }
    else { try{ val = Function('"use strict"; return (' + expr + ')')(); if(typeof val!=='number'||!isFinite(val)) val='#ERR'; else val=Math.round(val*1e10)/1e10; }catch(e){ val='#ERR'; } }
  } else { val = raw; }
  cache.set(key, val);
  return val;
}

function computeGrid(sheet){
  const cache = new Map(); const grid = [];
  for(let r=0;r<sheet.rows;r++){
    const row=[];
    for(let c=0;c<sheet.cols;c++) row.push(String(evalCell(sheet, cellKey(r,c), cache, new Set())));
    grid.push(row);
  }
  return grid;
}
function computeDisplayGrid(sheet){   // nilai seperti yang tampak di layar (format Rupiah, persen, dll.)
  const cache = new Map(), fmt = sheet.fmt || {}; const grid = [];
  for(let r=0;r<sheet.rows;r++){ const row=[]; for(let c=0;c<sheet.cols;c++){ const k = cellKey(r,c); row.push(applyNumFmt(String(evalCell(sheet, k, cache, new Set())), fmt[k])); } grid.push(row); }
  return grid;
}
function csvEscape(v){ v = v==null?'':String(v); return /[",\r\n]/.test(v) ? '"'+v.replace(/"/g,'""')+'"' : v; }
function sheetToCSV(sheet){
  const grid = computeGrid(sheet);
  const header = ['', ...Array.from({length:sheet.cols},(_,c)=>colLetter(c))];
  const lines = [header, ...grid.map((row,r)=>[String(r+1), ...row])];
  return lines.map(row=>row.map(csvEscape).join(',')).join('\r\n');
}
function hexRgb(h){ h = safeColor(h); if(!h) return null; let x = h.slice(1); if(x.length === 3) x = x.split('').map(c=>c+c).join(''); const n = parseInt(x.slice(0,6), 16); return [(n>>16)&255, (n>>8)&255, n&255]; }
function sheetToPDFBlob(sheet){
  const { jsPDF } = window.jspdf || {};
  if(!jsPDF || !jsPDF.API || !jsPDF.API.autoTable) return null;
  const grid = computeDisplayGrid(sheet);
  const head = [['', ...Array.from({length:sheet.cols},(_,c)=>colLetter(c))]];
  const body = grid.map((row,r)=>[String(r+1), ...row]);
  const doc = new jsPDF();
  doc.setFontSize(14);
  doc.text(sheet.name || 'Tabel', 14, 16);
  const fmt = sheet.fmt || {};
  const pdfFmt = d => (d.section==='body' && d.column.index>0) ? fmt[cellKey(d.row.index, d.column.index-1)] : null;
  doc.autoTable({ head, body, startY: 22, styles:{ fontSize:8, cellPadding:3 }, headStyles:{ fillColor:[59,130,246] },
    didParseCell: d=>{
      const f = pdfFmt(d); if(!f) return;
      d.cell.styles.fontStyle = f.b&&f.i ? 'bolditalic' : f.b ? 'bold' : f.i ? 'italic' : 'normal';
      const bg = hexRgb(f.bg), fg = hexRgb(f.c); if(bg) d.cell.styles.fillColor = bg; if(fg) d.cell.styles.textColor = fg;
      const ha = f.ha || (f.nf ? 'right' : ''); if(ha) d.cell.styles.halign = ha;
    },
    didDrawCell: d=>{
      const f = pdfFmt(d); if(!f || (!f.u && !f.x)) return;
      const txt = (d.cell.text||[]).join(' ').trim(); if(!txt) return;
      doc.setFont('helvetica', f.b&&f.i ? 'bolditalic' : f.b ? 'bold' : f.i ? 'italic' : 'normal'); doc.setFontSize(8);
      const p = d.cell.getTextPos(); const w = doc.getTextWidth(txt);
      const h = doc.getFontSize() / doc.internal.scaleFactor;
      let x0 = p.x; const ha = f.ha || (f.nf ? 'right' : '');
      if(ha === 'right') x0 = d.cell.x + d.cell.width - d.cell.padding('right') - w; else if(ha === 'center') x0 = d.cell.x + (d.cell.width - w) / 2;
      doc.setDrawColor(0); doc.setLineWidth(0.2);
      if(f.u){ const uy = p.y + h * 0.95; doc.line(x0, uy, x0 + w, uy); }        // getTextPos = tepi ATAS teks
      if(f.x){ const sy = p.y + h * 0.5; doc.line(x0, sy, x0 + w, sy); }
    } });
  return doc.output('blob');
}
function sheetToMemoText(sheet){
  const grid = computeGrid(sheet);
  const header = ['   ', ...Array.from({length:sheet.cols},(_,c)=>colLetter(c).padEnd(8,' '))];
  const lines = [header.join(' | '), ...grid.map((row,r)=>[String(r+1).padEnd(3,' '), ...row.map(v=>v.padEnd(8,' '))].join(' | '))];
  return lines.join('\n');
}
async function tryDownloadsSave(filename, data){
  let downloads = null;
  if(window.claude && typeof window.claude.use === 'function'){ try{ downloads = await window.claude.use('downloads'); }catch(e){ downloads = null; } }
  if(downloads){
    try{ await downloads.save({filename, data}); toast('File siap diunduh / dibagikan'); }
    catch(err){ if(err && err.code === 'declined') return; toast('Gagal menyiapkan file untuk diunduh'); }
    return;
  }
  try{   // pemakaian biasa di browser: unduh langsung
    const blob = data instanceof Blob ? data : new Blob(['﻿' + data], {type:'text/csv;charset=utf-8'});
    const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = filename;
    document.body.appendChild(a); a.click(); a.remove();
    setTimeout(()=>URL.revokeObjectURL(a.href), 4000);
    toast('File diunduh: ' + filename);
  }catch(e){ toast('Gagal menyiapkan file untuk diunduh'); }
}

async function pageSheets(){
  const sheets = (await all('sheets')).sort((a,b)=>b.createdAt-a.createdAt);
  return `
  <div class="section-title">📊 Tabel</div>
  <div class="section-sub">Buat tabel bebas seperti spreadsheet — bisa isi angka, teks, dan rumus (misalnya =SUM(A1:A5)).</div>
  <div class="sheet-card-grid">
    ${sheets.map(s=>`<div class="fcard" data-opensheet="${s.id}"><div class="icon">📊</div><div class="fn">${esc(s.name)}</div><div class="fc">${s.rows}×${s.cols} · ${fmtDate(new Date(s.createdAt).toISOString())}</div></div>`).join('')}
    ${!sheets.length?'<div class="empty" style="grid-column:1/-1;">Belum ada tabel. Tekan + untuk membuat tabel pertama.</div>':''}
  </div>`;
}
function wireSheets(){
  document.querySelectorAll('[data-opensheet]').forEach(el=>el.addEventListener('click', ()=>{ activeSheetId=Number(el.dataset.opensheet); view='sheet'; render(); }));
}
function openSheetModal(){
  const html = `<div class="overlay" id="ovSheet"><div class="modal">
    <h3>Buat Tabel Baru</h3>
    <div class="field"><label>Nama Tabel</label><input id="sh_name" placeholder="Contoh: Rekap Belanja"></div>
    <div class="modal-actions"><button class="btn ghost" id="shAnc">Batal</button><button class="btn" id="shOk">Buat Tabel</button></div>
  </div></div>`;
  document.body.insertAdjacentHTML('beforeend', html);
  attachAutoCapitalize(document.getElementById('sh_name'));
  document.getElementById('shAnc').onclick = ()=>document.getElementById('ovSheet').remove();
  const sheetUid = uuid();                       // satu kode untuk satu tabel baru (anti dobel di server)
  let sheetBusy = false;
  document.getElementById('shOk').onclick = async ()=>{
    if(sheetBusy) return;                        // klik kedua saat server masih menjawab diabaikan
    const name = document.getElementById('sh_name').value.trim();
    if(!name){ toast('Nama tabel wajib diisi'); return; }
    sheetBusy = true;
    const okBtn = document.getElementById('shOk'); okBtn.disabled = true; okBtn.textContent = 'Membuat…';
    try{
      const id = await put('sheets', {name, rows:8, cols:6, cells:{}, createdAt:Date.now(), uid:sheetUid});
      markWrite(); toast('Tabel dibuat'); const ov = document.getElementById('ovSheet'); if(ov) ov.remove();
      activeSheetId = id; view='sheet'; render();
    }catch(e){
      sheetBusy = false; okBtn.disabled = false; okBtn.textContent = 'Buat Tabel'; toast('Gagal membuat tabel, coba lagi');
    }
  };
}
/* ---- Format sel Tabel (B / I / U) + pemilihan sel ---- */
let sheetSel = new Set(), sheetAnchor = null, sheetMulti = false, sheetSelOwner = null, editing = null;
function parseKey(k){ const [r,c] = k.split('_').map(Number); return {r,c}; }
function selectRange(a, b){
  const A = parseKey(a), B = parseKey(b), s = new Set();
  for(let r=Math.min(A.r,B.r); r<=Math.max(A.r,B.r); r++)
    for(let c=Math.min(A.c,B.c); c<=Math.max(A.c,B.c); c++) s.add(cellKey(r,c));
  sheetSel = s;
}
function applySelClasses(){
  document.querySelectorAll('table.sheet td[data-key]').forEach(td=>td.classList.toggle('sel', sheetSel.has(td.dataset.key)));
  const info = document.getElementById('selInfo');
  if(info) info.textContent = sheetSel.size ? sheetSel.size + ' sel dipilih' : 'Pilih sel untuk memformat';
  const mb = document.getElementById('btnMulti');
  if(mb) mb.classList.toggle('on', sheetMulti);
  refreshSheetToolbar();
}
/* ---- Undo / Redo Tabel: riwayat terpisah per tabel, disimpan di memori selama halaman terbuka ---- */
const sheetHist = {};
function shHist(id){ return sheetHist[id] || (sheetHist[id] = {undo:[], redo:[]}); }
const shPool = new Map();   // id foto tabel -> data URL (tidak disalin ke tiap langkah Undo)
const sheetShot = s => JSON.stringify({rows:s.rows, cols:s.cols, cells:s.cells||{}, fmt:s.fmt||{}, photos:(s.photos||[]).map(p=>({id:p.id, w:p.w}))});
let sheetQ = Promise.resolve();   // semua baca-ubah-tulis tabel diantrekan supaya tidak saling menimpa
function sheetTask(fn){ const p = sheetQ.then(fn); sheetQ = p.catch(()=>{}); return p; }
// fn(s) mengubah objek tabel (return false = batal). Hasil true bila ada perubahan nyata yang disimpan + dicatat di riwayat.
function mutateSheet(fn){
  const id = activeSheetId;
  return sheetTask(async()=>{
    const s = await get('sheets', id); if(!s) return false;
    const before = sheetShot(s);
    if(fn(s) === false) return false;
    if(sheetShot(s) === before) return false;
    s.updatedAt = Date.now();               // tidak ada perubahan -> bukan langkah riwayat
    const h = shHist(id);
    if(!h.undo.length && !h.redo.length && s.imgs){ const used = new Set(Object.values(s.fmt||{}).map(f=>f.img)); Object.keys(s.imgs).forEach(k=>{ if(!used.has(k)) delete s.imgs[k]; }); }   // bersihkan foto yatim saat riwayat masih kosong
    h.undo.push(before); if(h.undo.length > HIST_MAX) h.undo.shift(); h.redo = [];
    await put('sheets', s); markWrite();
    return true;
  });
}
// Ketikan di dalam sel disimpan otomatis ~1 detik setelah berhenti (editor tetap terbuka). Langkah Undo baru dicatat
// saat sel selesai diedit, jadi satu kali mengetik tetap = satu langkah Undo.
let sheetAutoTimer = null, sheetAutoSince = 0;
function sheetAutosaveSoon(){
  if(!editing) return;
  const now = Date.now(); if(!sheetAutoSince) sheetAutoSince = now;
  clearTimeout(sheetAutoTimer);
  if(now - sheetAutoSince > 5000){ sheetAutosave(); return; }
  sheetAutoTimer = setTimeout(sheetAutosave, 900);
}
function sheetAutosave(){
  clearTimeout(sheetAutoTimer); sheetAutoSince = 0;
  const ed = editing; if(!ed) return Promise.resolve();
  const id = activeSheetId, key = ed.key, val = ed.inp.value;
  return sheetTask(async()=>{
    const s = await get('sheets', id); if(!s) return;
    const cur = sheetShot(s);
    s.cells = s.cells || {};
    if(val === '') delete s.cells[key]; else s.cells[key] = val;
    if(sheetShot(s) === cur) return;
    if(ed.baseShot === undefined) ed.baseShot = cur;       // keadaan sebelum ketikan ini = titik kembali Undo
    s.updatedAt = Date.now();
    await put('sheets', s); markWrite();
  });
}
async function commitEdit(rerender){
  if(!editing) return;
  const ed = editing; editing = null; clearTimeout(sheetAutoTimer); sheetAutoSince = 0;
  const val = ed.inp.value, key = ed.key, id = activeSheetId;
  await sheetTask(async()=>{
    const s = await get('sheets', id); if(!s) return;
    const dbShot = sheetShot(s);
    const before = ed.baseShot !== undefined ? ed.baseShot : dbShot;
    s.cells = s.cells || {};
    if(val === '') delete s.cells[key]; else s.cells[key] = val;
    const after = sheetShot(s);
    if(after !== dbShot){ s.updatedAt = Date.now(); await put('sheets', s); markWrite(); }
    if(after !== before){ const h = shHist(id); h.undo.push(before); if(h.undo.length > HIST_MAX) h.undo.shift(); h.redo = []; }
  });
  if(rerender) await render();
}
async function sheetStep(dir){
  await commitEdit(false); // simpan dulu ketikan sel yang sedang diedit (jadi langkah riwayat tersendiri)
  const id = activeSheetId;
  const changed = await sheetTask(async()=>{
    const h = shHist(id), from = dir === 'undo' ? h.undo : h.redo, to = dir === 'undo' ? h.redo : h.undo;
    if(!from.length) return false;
    const s = await get('sheets', id); if(!s) return false;
    to.push(sheetShot(s));
    const snap = JSON.parse(from.pop());
    s.rows = snap.rows; s.cols = snap.cols; s.cells = snap.cells; s.fmt = snap.fmt; s.photos = (snap.photos||[]).map(p=>({id:p.id, w:p.w, src:shPool.get(p.id)||''})).filter(p=>p.src); s.updatedAt = Date.now();   // nama tabel tidak ikut diubah
    await put('sheets', s); markWrite();
    return true;
  });
  if(changed) render(); else updateUndoButtons();
}
/* ---- Format sel: B/I/U/S, font, ukuran, warna, rata, format angka, batas, kuas ---- */
// Format disimpan per sel di s.fmt[key] = {b,i,u,x, fs, ff, c, bg, ha, va, nf, dec, bd:{t,r,b,l}}. Tidak pernah menyentuh s.cells, jadi rumus aman.
let curSheet = null;          // salinan tabel yang sedang tampil (untuk salin/tempel & status toolbar)
let sheetClip = null, fmtBrush = null;
const fmtOf = k => ((curSheet && curSheet.fmt) || {})[k] || {};
async function applyFmt(mut){
  if(!sheetSel.size){ toast('Pilih sel dulu, lalu pilih format'); return false; }
  await commitEdit(false); // simpan dulu ketikan sel yang sedang diedit supaya isinya tidak hilang
  const keys = [...sheetSel];
  await mutateSheet(s=>{
    s.fmt = s.fmt || {};
    keys.forEach(k=>{ const f = s.fmt[k] || (s.fmt[k] = {}); mut(f, k, s); if(!Object.keys(f).length) delete s.fmt[k]; });
  });
  render();
  return true;
}
// flag: 'b' | 'i' | 'u' | 'x' (toggle) atau null (hapus semua format)
function applySheetFormat(flag){
  if(flag === null) return applyFmt(f=>{ Object.keys(f).forEach(p=>delete f[p]); });
  const keys = [...sheetSel];
  const allOn = keys.length > 0 && keys.every(k=>fmtOf(k)[flag]);
  return applyFmt(f=>{ if(allOn) delete f[flag]; else f[flag] = 1; });
}
const setFmtProp = (p, v) => applyFmt(f=>{ if(v == null || v === '') delete f[p]; else f[p] = v; });
function setNumFmt(nf){ return applyFmt(f=>{ if(!nf){ delete f.nf; delete f.dec; } else f.nf = nf; }); }
function stepSize(dir){
  const k = [...sheetSel][0]; if(!k){ toast('Pilih sel dulu'); return; }
  const cur = fmtOf(k).fs || 13; let i;
  if(dir > 0){ i = FONT_SIZES.findIndex(x=>x > cur); if(i < 0) i = FONT_SIZES.length - 1; }
  else { i = -1; FONT_SIZES.forEach((x,j)=>{ if(x < cur) i = j; }); if(i < 0) i = 0; }
  return setFmtProp('fs', FONT_SIZES[i]);
}
function stepDec(dir){
  const k = [...sheetSel][0]; if(!k){ toast('Pilih sel dulu'); return; }
  const f = fmtOf(k); let base = f.dec;
  if(base == null){
    const n = toNum(evalCell(curSheet, k, new Map(), new Set()), f.nf === 'rupiah');
    base = isFinite(n) ? (f.nf === 'percent' ? Math.max(0, natDec(n) - 2) : natDec(n)) : 0;
  }
  const nd = Math.max(0, Math.min(10, base + dir));
  return applyFmt(g=>{ g.dec = nd; });
}
function applyBorder(kind){
  const ps = [...sheetSel].map(parseKey); if(!ps.length){ toast('Pilih sel dulu'); return; }
  const r1 = Math.min(...ps.map(p=>p.r)), r2 = Math.max(...ps.map(p=>p.r)), c1 = Math.min(...ps.map(p=>p.c)), c2 = Math.max(...ps.map(p=>p.c));
  return applyFmt((f,k)=>{
    if(kind === 'none'){ delete f.bd; return; }
    const {r,c} = parseKey(k), b = Object.assign({}, f.bd);
    if(kind === 'all'){ b.t = b.b = b.l = b.r = 1; }
    else {
      if((kind === 'outer' || kind === 'top') && r === r1) b.t = 1;
      if((kind === 'outer' || kind === 'bottom') && r === r2) b.b = 1;
      if((kind === 'outer' || kind === 'left') && c === c1) b.l = 1;
      if((kind === 'outer' || kind === 'right') && c === c2) b.r = 1;
    }
    f.bd = b;
  });
}
// Kuas format: tekan sekali = salin format sel terpilih; pilih sel tujuan lalu tekan lagi = tempel format.
function sheetBrush(){
  const keys = [...sheetSel]; if(!keys.length){ toast('Pilih sel sumber dulu'); return; }
  if(!fmtBrush){ fmtBrush = {f: JSON.parse(JSON.stringify(fmtOf(keys[0])))}; refreshSheetToolbar(); toast('Format disalin. Pilih sel tujuan, lalu tekan ikon kuas lagi.', 4000); return; }
  const src = fmtBrush.f; fmtBrush = null;
  return applyFmt(f=>{ Object.keys(f).forEach(p=>delete f[p]); Object.assign(f, JSON.parse(JSON.stringify(src))); });
}
async function clearContents(){
  if(!sheetSel.size){ toast('Pilih sel dulu'); return; }
  await commitEdit(false);
  const keys = [...sheetSel];
  const ok = await mutateSheet(s=>{ s.cells = s.cells || {}; keys.forEach(k=>delete s.cells[k]); });
  render(); if(ok) toast('Isi sel dihapus (format tetap)');
}
// Sisip / hapus baris atau kolom: sel & format di bawah/kanan ikut bergeser, rumus ikut disesuaikan.
function shiftFormulaRefs(raw, axis, at, count){
  if(typeof raw !== 'string' || raw[0] !== '=') return raw;
  const adj = (idx, role)=>{
    if(count > 0) return idx >= at ? idx + count : idx;
    const n = -count; if(idx >= at + n) return idx - n;
    if(idx >= at){ if(role === 'start') return at; if(role === 'end') return at - 1; return null; }
    return idx;
  };
  const fix = (col, row, role)=>{
    let c = colIndex(col.toUpperCase()), r = parseInt(row) - 1;
    if(axis === 'row') r = adj(r, role); else c = adj(c, role);
    return (r == null || c == null || r < 0 || c < 0) ? null : {r, c};
  };
  const name = p => colLetter(p.c) + (p.r + 1);
  return raw.replace(/\b([A-Za-z]+)(\d+)(?::([A-Za-z]+)(\d+))?\b/g, (m,c1,r1,c2,r2)=>{
    if(c2){ const a = fix(c1,r1,'start'), b = fix(c2,r2,'end'); return (a && b && b.r >= a.r && b.c >= a.c) ? name(a) + ':' + name(b) : '#REF'; }
    const a = fix(c1,r1,'single'); return a ? name(a) : '#REF';
  });
}
function remapSheet(s, axis, at, count){
  const mapIdx = i => { if(count > 0) return i >= at ? i + count : i; const n = -count; if(i < at) return i; if(i < at + n) return null; return i - n; };
  const rm = obj => { const out = {}; for(const k in obj){ const {r,c} = parseKey(k); const nr = axis === 'row' ? mapIdx(r) : r, nc = axis === 'col' ? mapIdx(c) : c; if(nr == null || nc == null) continue; out[cellKey(nr,nc)] = obj[k]; } return out; };
  s.cells = rm(s.cells || {}); s.fmt = rm(s.fmt || {});
  for(const k in s.cells) s.cells[k] = shiftFormulaRefs(s.cells[k], axis, at, count);
  if(axis === 'col' && s.filter){ s.filter.cols = {}; s.filter.sort = null; }   // nomor kolom bergeser: kriteria filter dikosongkan
  if(axis === 'row') s.rows += count; else s.cols += count;
}
async function sheetInsert(axis){
  await commitEdit(false);
  const ps = [...sheetSel].map(parseKey);
  const ok = await mutateSheet(s=>{
    const cnt = axis === 'row' ? s.rows : s.cols;
    if(cnt >= (axis === 'row' ? 500 : 60)) return false;
    const at = ps.length ? Math.max(...ps.map(p=>axis === 'row' ? p.r : p.c)) + 1 : cnt;   // di bawah/kanan sel terpilih, atau di akhir
    remapSheet(s, axis, at, 1);
  });
  if(!ok) toast('Batas ukuran tabel tercapai');
  render();
}
async function sheetDelete(axis){
  await commitEdit(false);
  const ps = [...sheetSel].map(parseKey);
  const idxs = [...new Set(ps.map(p=>axis === 'row' ? p.r : p.c))].sort((a,b)=>b-a);
  const ok = await mutateSheet(s=>{
    const cnt = axis === 'row' ? s.rows : s.cols;
    const list = idxs.length ? idxs : [cnt - 1];     // tanpa pilihan: hapus yang paling akhir
    if(list.length >= cnt) return false;
    list.forEach(i=>remapSheet(s, axis, i, -1));
  });
  if(!ok) toast(axis === 'row' ? 'Minimal 1 baris' : 'Minimal 1 kolom');
  sheetSel = new Set(); sheetAnchor = null;
  render();
}
/* ---- Salin / tempel / hapus isi sel & pintasan keyboard (saat tidak sedang mengetik di sel) ---- */
function selBounds(){
  const ps = [...sheetSel].map(parseKey); if(!ps.length) return null;
  return {r1:Math.min(...ps.map(p=>p.r)), r2:Math.max(...ps.map(p=>p.r)), c1:Math.min(...ps.map(p=>p.c)), c2:Math.max(...ps.map(p=>p.c))};
}
const inField = a => a && a !== document.body && (/^(INPUT|TEXTAREA|SELECT)$/.test(a.tagName) || a.isContentEditable);
function sheetCopy(e, cut){
  if(view !== 'sheet' || editing || !sheetSel.size || !curSheet || document.querySelector('.overlay') || inField(document.activeElement)) return;
  const b = selBounds(), lines = [], cells = [];
  for(let r=b.r1; r<=b.r2; r++){
    const line = [], cl = [];
    for(let c=b.c1; c<=b.c2; c++){ const k = cellKey(r,c), raw = (curSheet.cells || {})[k] || ''; line.push(raw); cl.push({raw, f: curSheet.fmt && curSheet.fmt[k] ? JSON.parse(JSON.stringify(curSheet.fmt[k])) : null}); }
    lines.push(line.join('\t')); cells.push(cl);
  }
  const text = lines.join('\n');
  e.clipboardData.setData('text/plain', text); e.preventDefault();
  sheetClip = {text, cells};
  if(cut) clearContents(); else toast('Sel disalin');
}
document.addEventListener('copy', e=>sheetCopy(e, false));
document.addEventListener('cut', e=>sheetCopy(e, true));
document.addEventListener('paste', e=>{
  if(view !== 'sheet' || editing || !sheetSel.size || !curSheet || document.querySelector('.overlay') || inField(document.activeElement)) return;
  const text = ((e.clipboardData || window.clipboardData).getData('text/plain') || '').replace(/\r/g, '');
  if(!text) return;
  e.preventDefault(); sheetPaste(text);
});
async function sheetPaste(text){
  const b = selBounds(); await commitEdit(false);
  const grid = text.replace(/\n$/, '').split('\n').map(l=>l.split('\t'));
  const useClip = !!(sheetClip && sheetClip.text === text.replace(/\n$/, ''));
  const keys = [...sheetSel];
  await mutateSheet(s=>{
    s.cells = s.cells || {}; s.fmt = s.fmt || {};
    const put1 = (k, raw, f)=>{
      if(raw === '') delete s.cells[k]; else s.cells[k] = raw;
      if(f !== undefined){ if(f) s.fmt[k] = JSON.parse(JSON.stringify(f)); else delete s.fmt[k]; }
    };
    if(grid.length === 1 && grid[0].length === 1 && keys.length > 1){          // satu nilai ke banyak sel terpilih
      keys.forEach(k=>put1(k, grid[0][0], useClip ? sheetClip.cells[0][0].f : undefined)); return;
    }
    const needR = b.r1 + grid.length, needC = b.c1 + Math.max(...grid.map(r=>r.length));
    if(needR > s.rows) s.rows = Math.min(needR, 500);
    if(needC > s.cols) s.cols = Math.min(needC, 60);
    grid.forEach((row, i)=>row.forEach((raw, j)=>{
      const r = b.r1 + i, c = b.c1 + j; if(r >= s.rows || c >= s.cols) return;
      put1(cellKey(r,c), raw, useClip ? (sheetClip.cells[i] && sheetClip.cells[i][j] ? sheetClip.cells[i][j].f : null) : undefined);
    }));
  });
  render(); toast('Ditempel');
}
document.addEventListener('keydown', e=>{
  if(view !== 'sheet' || editing || !sheetSel.size || document.querySelector('.overlay') || inField(document.activeElement)) return;
  const k = (e.key || '').toLowerCase(), mod = e.ctrlKey || e.metaKey;
  if(mod && !e.altKey && !e.shiftKey && (k === 'b' || k === 'i' || k === 'u')){ e.preventDefault(); applySheetFormat(k); return; }
  if(mod || e.altKey) return;
  if(k === 'delete' || k === 'backspace'){ e.preventDefault(); clearContents(); return; }
  const first = [...sheetSel][0];
  if((k === 'enter' || k === 'f2') && sheetSel.size === 1){
    e.preventDefault(); const cv = document.querySelector('td[data-key="' + first + '"] .cellval'); if(cv) cv.click(); return;
  }
  const d = {arrowup:[-1,0], arrowdown:[1,0], arrowleft:[0,-1], arrowright:[0,1]}[k];
  if(d && curSheet){
    e.preventDefault();
    const p = parseKey(sheetAnchor && sheetSel.has(sheetAnchor) ? sheetAnchor : first);
    let r = Math.max(0, Math.min(curSheet.rows - 1, p.r + d[0])); const c = Math.max(0, Math.min(curSheet.cols - 1, p.c + d[1]));
    while(d[0] && curHidden.has(r) && r + d[0] >= 0 && r + d[0] < curSheet.rows) r += d[0];
    if(curHidden.has(r)) r = p.r;
    const nk = cellKey(r,c);
    sheetSel = new Set([nk]); sheetAnchor = nk; applySelClasses();
    const td = document.querySelector('td[data-key="' + nk + '"]'); if(td && td.scrollIntoView) td.scrollIntoView({block:'nearest', inline:'nearest'});
  }
});
/* ---- Rumus cepat (Σ) ---- */
const FUNCS = [['SUM','Jumlah  (SUM)'],['AVERAGE','Rata-rata  (AVERAGE)'],['MIN','Terkecil  (MIN)'],['MAX','Terbesar  (MAX)'],['COUNT','Hitung angka  (COUNT)'],['COUNTA','Hitung sel terisi  (COUNTA)'],['MEDIAN','Nilai tengah  (MEDIAN)'],['PRODUCT','Perkalian  (PRODUCT)']];
// Pilih rentang lalu pilih rumus: hasil diletakkan di bawah rentang (kolom) atau di kanan rentang (satu baris). Satu sel kosong: otomatis memakai angka di atas / di kirinya.
async function insertFunc(fn){
  if(!sheetSel.size || !curSheet){ toast('Pilih sel atau rentang dulu'); return; }
  await commitEdit(false);
  const b = selBounds(), cells = curSheet.cells || {}, rawAt = (r,c)=>cells[cellKey(r,c)] || '';
  const isNum = (r,c)=>{ const v = rawAt(r,c); return v !== '' && (String(v)[0] === '=' || isFinite(toNum(v))); };
  const writes = []; let needRows = curSheet.rows, needCols = curSheet.cols;
  const A = (r,c)=>colLetter(c) + (r+1);
  if(sheetSel.size === 1 && rawAt(b.r1,b.c1) === ''){
    let r = b.r1 - 1; while(r >= 0 && isNum(r,b.c1)) r--;
    let c = b.c1 - 1; while(c >= 0 && isNum(b.r1,c)) c--;
    if(b.r1 - 1 > r) writes.push([b.r1, b.c1, `=${fn}(${A(r+1,b.c1)}:${A(b.r1-1,b.c1)})`]);
    else if(b.c1 - 1 > c) writes.push([b.r1, b.c1, `=${fn}(${A(b.r1,c+1)}:${A(b.r1,b.c1-1)})`]);
    else { toast('Tidak ada angka di atas atau di kiri sel ini. Pilih rentang sel dulu (Shift+klik).', 4000); return; }
  } else if(b.r1 === b.r2 && b.c1 < b.c2){
    writes.push([b.r1, b.c2 + 1, `=${fn}(${A(b.r1,b.c1)}:${A(b.r1,b.c2)})`]);
  } else {
    for(let c = b.c1; c <= b.c2; c++) writes.push([b.r2 + 1, c, `=${fn}(${A(b.r1,c)}:${A(b.r2,c)})`]);
  }
  writes.forEach(([r,c])=>{ needRows = Math.max(needRows, r + 1); needCols = Math.max(needCols, c + 1); });
  const clash = writes.filter(([r,c])=>r < curSheet.rows && c < curSheet.cols && rawAt(r,c) !== '' ).length;
  const ok = await mutateSheet(s=>{
    s.cells = s.cells || {}; s.rows = Math.min(500, Math.max(s.rows, needRows)); s.cols = Math.min(60, Math.max(s.cols, needCols));
    writes.forEach(([r,c,f])=>{ s.cells[cellKey(r,c)] = f; });
  });
  render(); if(ok) toast(`Rumus ${fn} dimasukkan ke ${writes.map(w=>A(w[0],w[1])).join(', ')}` + (clash ? ` (menimpa ${clash} sel yang terisi — bisa di-Undo)` : ''), 4500);
}
/* ---- Filter & urutkan kolom (tampilan saja: data asli tidak diubah / dipindah) ---- */
let curHidden = new Set();
function colPass(cf, disp, raw){
  if(!cf) return true;
  if(cf.vals && cf.vals.includes(disp)) return false;
  if(cf.op){
    const d = disp.toLowerCase(), v = String(cf.v || '').toLowerCase(), n = toNum(raw), nv = toNum(cf.v), both = isFinite(n) && isFinite(nv);
    switch(cf.op){
      case 'contains': if(!d.includes(v)) return false; break;
      case 'notcontains': if(d.includes(v)) return false; break;
      case 'eq': if(both ? n !== nv : d !== v) return false; break;
      case 'gt': if(!(both && n > nv)) return false; break;
      case 'lt': if(!(both && n < nv)) return false; break;
      case 'ge': if(!(both && n >= nv)) return false; break;
      case 'le': if(!(both && n <= nv)) return false; break;
      case 'empty': if(d !== '') return false; break;
      case 'notempty': if(d === '') return false; break;
    }
  }
  return true;
}
// Baris 1 dianggap judul (selalu tampil). Hasil: urutan baris yang tampil + baris yang tersembunyi.
function sheetRowOrder(sheet, dgrid, rgrid){
  const f = sheet.filter && sheet.filter.on ? sheet.filter : null, all = [...Array(sheet.rows).keys()];
  if(!f) return {order: all, hidden: new Set()};
  const cols = f.cols || {};
  let rows = all.slice(1).filter(r=>Object.keys(cols).every(c=>Number(c) >= sheet.cols || colPass(cols[c], dgrid[r][c], rgrid[r][c])));
  if(f.sort && f.sort.c < sheet.cols){
    const c = f.sort.c, d = f.sort.dir === 'desc' ? -1 : 1;
    rows.sort((a,b)=>{
      const x = dgrid[a][c], y = dgrid[b][c];
      if(x === '' && y === '') return a - b; if(x === '') return 1; if(y === '') return -1;     // sel kosong selalu di bawah
      const nx = toNum(rgrid[a][c]), ny = toNum(rgrid[b][c]);
      const cmp = (isFinite(nx) && isFinite(ny)) ? nx - ny : x.localeCompare(y, 'id', {sensitivity:'base'});
      return cmp ? cmp * d : a - b;
    });
  }
  const order = [0, ...rows], shown = new Set(order);
  return {order, hidden: new Set(all.filter(r=>!shown.has(r)))};
}
async function saveFilter(mut){
  await commitEdit(false);
  await sheetTask(async()=>{
    const s = await get('sheets', activeSheetId); if(!s) return;
    s.filter = s.filter || {on:true, cols:{}, sort:null}; s.filter.on = true; mut(s.filter);
    s.updatedAt = Date.now(); await put('sheets', s); markWrite();
  });
  render();
}
async function toggleFilter(){
  await commitEdit(false);
  await sheetTask(async()=>{
    const s = await get('sheets', activeSheetId); if(!s) return;
    if(s.filter && s.filter.on) delete s.filter; else s.filter = {on:true, cols:{}, sort:null};
    s.updatedAt = Date.now(); await put('sheets', s); markWrite();
  });
  render();
}
const FILTER_OPS = [['','Tidak ada'],['contains','Teks berisi'],['notcontains','Teks tidak berisi'],['eq','Sama dengan'],['gt','Lebih besar dari'],['ge','Lebih besar atau sama dengan'],['lt','Lebih kecil dari'],['le','Lebih kecil atau sama dengan'],['empty','Kosong'],['notempty','Tidak kosong']];
function openFilterPop(anchor, c){
  const sheet = curSheet; if(!sheet) return;
  const f = sheet.filter || {cols:{}}, cf = (f.cols && f.cols[c]) || {};
  const dg = computeDisplayGrid(sheet);
  const uniq = [...new Set(Array.from({length: sheet.rows - 1}, (_,i)=>dg[i+1][c]))].sort((a,b)=>a === '' ? 1 : b === '' ? -1 : a.localeCompare(b, 'id', {numeric:true, sensitivity:'base'})).slice(0, 300);
  openPop(anchor, pop=>{
    pop.style.width = '270px'; pop.style.maxWidth = '92vw';
    pop.innerHTML = `
      <div style="display:flex;gap:6px;padding:2px 2px 4px;"><button type="button" class="btn small ghost" data-s="asc" style="flex:1">A → Z</button><button type="button" class="btn small ghost" data-s="desc" style="flex:1">Z → A</button></div>
      <label class="lbl">Filter menurut kondisi</label>
      <select id="fl_op">${FILTER_OPS.map(([v,l])=>`<option value="${v}"${cf.op === v || (!cf.op && v === '') ? ' selected' : ''}>${l}</option>`).join('')}</select>
      <input type="text" id="fl_v" placeholder="Nilai…" value="${esc(cf.v || '')}">
      <label class="lbl">Filter menurut nilai <span style="font-weight:500">· <a href="#" id="fl_all">Pilih semua</a> · <a href="#" id="fl_none">Kosongkan</a></span></label>
      <div id="fl_list" style="max-height:170px;overflow:auto;border:1px solid var(--line);border-radius:8px;padding:2px 6px;margin-top:4px;">
        ${uniq.map((u,i)=>`<label class="fl-row"><input type="checkbox" data-i="${i}"${cf.vals && cf.vals.includes(u) ? '' : ' checked'}> <span>${u === '' ? '(Kosong)' : esc(u)}</span></label>`).join('') || '<div class="dash-empty">Belum ada data di bawah judul.</div>'}
      </div>
      <div class="modal-actions" style="margin-top:10px;"><button type="button" class="btn small ghost" id="fl_clear">Hapus filter kolom</button><button type="button" class="btn small" id="fl_ok">Terapkan</button></div>`;
    const q = s=>pop.querySelector(s);
    pop.querySelectorAll('[data-s]').forEach(b=>b.addEventListener('click', ()=>{ closePops(); saveFilter(fl=>{ fl.sort = {c, dir:b.dataset.s}; }); }));
    q('#fl_all').addEventListener('click', e=>{ e.preventDefault(); pop.querySelectorAll('[data-i]').forEach(x=>x.checked = true); });
    q('#fl_none').addEventListener('click', e=>{ e.preventDefault(); pop.querySelectorAll('[data-i]').forEach(x=>x.checked = false); });
    q('#fl_clear').addEventListener('click', ()=>{ closePops(); saveFilter(fl=>{ if(fl.cols) delete fl.cols[c]; if(fl.sort && fl.sort.c === c) fl.sort = null; }); });
    q('#fl_ok').addEventListener('click', ()=>{
      const vals = uniq.filter((u,i)=>!pop.querySelector(`[data-i="${i}"]`).checked), op = q('#fl_op').value, v = q('#fl_v').value;
      closePops();
      saveFilter(fl=>{
        fl.cols = fl.cols || {}; const o = {};
        if(vals.length) o.vals = vals;
        if(op){ o.op = op; o.v = v; }
        if(Object.keys(o).length) fl.cols[c] = o; else delete fl.cols[c];
      });
    });
  });
}
function refreshSheetToolbar(){
  const tb = document.getElementById('shTb'); if(!tb || !curSheet) return;
  const keys = [...sheetSel], first = keys.length ? fmtOf(keys[0]) : {};
  const all = fl => keys.length > 0 && keys.every(k=>fmtOf(k)[fl]);
  [['fmtB','b'],['fmtI','i'],['fmtU','u'],['fmtS','x']].forEach(([id,fl])=>{ const b = document.getElementById(id); if(b) b.classList.toggle('on', all(fl)); });
  const q = id => document.getElementById(id);
  q('fmtFontLbl').textContent = first.ff || 'Inter';
  q('fsVal').textContent = first.fs || 13;
  q('barColor').style.background = safeColor(first.c) || 'var(--ink)';
  q('barFill').style.background = safeColor(first.bg) || 'transparent';
  const ha = first.ha || (first.nf ? 'right' : 'left');
  tb.querySelectorAll('[data-ha]').forEach(b=>b.classList.toggle('on', keys.length > 0 && ha === b.dataset.ha));
  q('fmtPaint').classList.toggle('on', !!fmtBrush);
}
function cellCss(f){
  let s = ''; const ff = safeFont(f.ff), c = safeColor(f.c);
  if(f.fs) s += 'font-size:' + (Number(f.fs) || 13) + 'px;';
  if(ff) s += "font-family:'" + ff + "',sans-serif;";
  if(c) s += 'color:' + c + ';';
  const ha = f.ha || (f.nf ? 'right' : '');
  if(ha === 'left' || ha === 'center' || ha === 'right') s += 'text-align:' + ha + ';';
  return s;
}
function cellClasses(f){ return (f.b?' fb':'') + (f.i?' fi':'') + (f.u?' fu':'') + (f.x?' fx':''); }
function cellToHtml(v, f){   // untuk "Salin ke Memo": format sel ikut terbawa
  let h = esc(v); if(!f || !h) return h;
  if(f.b) h = '<b>' + h + '</b>'; if(f.i) h = '<i>' + h + '</i>'; if(f.u) h = '<u>' + h + '</u>'; if(f.x) h = '<s>' + h + '</s>';
  let st = ''; const c = safeColor(f.c), bg = safeColor(f.bg);
  if(c) st += 'color:' + c + ';'; if(bg) st += 'background-color:' + bg + ';'; if(f.fs) st += 'font-size:' + (Number(f.fs) || 13) + 'px;';
  if(st) h = '<span style="' + st + '">' + h + '</span>';
  const ha = f.ha || (f.nf ? 'right' : '');
  if(ha === 'right' || ha === 'center') h = '<div style="text-align:' + ha + ';">' + h + '</div>';
  return h;
}
async function pageSheetDetail(){
  const sheet = await get('sheets', activeSheetId);
  if(!sheet){ view='sheets'; return pageSheets(); }
  curSheet = sheet;
  const cache = new Map();
  if(sheetSelOwner !== activeSheetId){ sheetSel = new Set(); sheetAnchor = null; sheetMulti = false; editing = null; sheetSelOwner = activeSheetId; fmtBrush = null; }
  const flt = sheet.filter && sheet.filter.on ? sheet.filter : null;
  const ro = sheetRowOrder(sheet, flt ? computeDisplayGrid(sheet) : null, flt ? computeGrid(sheet) : null);
  curHidden = ro.hidden;
  sheetSel = new Set([...sheetSel].filter(k=>{ const p = parseKey(k); return p.r < sheet.rows && p.c < sheet.cols && !curHidden.has(p.r); }));
  const fmt = sheet.fmt || {};
  const fcActive = c => flt && ((flt.cols && flt.cols[c]) || (flt.sort && flt.sort.c === c));
  let thead = '<tr><th class="corner"></th>' + Array.from({length:sheet.cols}, (_,c)=>`<th data-colsel="${c}" title="Pilih seluruh kolom ${colLetter(c)}">${colLetter(c)}${flt?`<button type="button" class="fbtn${fcActive(c)?' on':''}" data-flt="${c}" title="Filter &amp; urutkan kolom ${colLetter(c)}">${flt.sort && flt.sort.c === c ? (flt.sort.dir === 'desc' ? '↓' : '↑') : '▾'}</button>`:''}</th>`).join('') + '</tr>';
  let rowsHtml = '';
  for(const r of ro.order){
    rowsHtml += `<tr><td class="rowhead" data-rowsel="${r}" title="Pilih seluruh baris ${r+1}">${r+1}</td>`;
    for(let c=0;c<sheet.cols;c++){
      const key = cellKey(r,c);
      const f = fmt[key] || {};
      const display = applyNumFmt(String(evalCell(sheet, key, cache, new Set())), f);
      const bg = safeColor(f.bg), bd = f.bd || {};
      let ts = '';
      if(bg) ts += 'background-color:' + bg + ';';
      if(f.va === 'top' || f.va === 'middle' || f.va === 'bottom') ts += 'vertical-align:' + f.va + ';';
      if(bd.t) ts += 'border-top:2px solid var(--ink);'; if(bd.b) ts += 'border-bottom:2px solid var(--ink);';
      if(bd.l) ts += 'border-left:2px solid var(--ink);'; if(bd.r) ts += 'border-right:2px solid var(--ink);';
      const cs = cellCss(f);
      rowsHtml += `<td data-key="${key}"${sheetSel.has(key)?' class="sel"':''}${ts?` style="${ts}"`:''}>${f.img && (sheet.imgs||{})[f.img] ? `<img class="cellimg" src="${imgUrl(f.img, sheet.imgs[f.img])}" alt="Foto sel" style="height:${f.iw||96}px;${f.ha==='center'?'margin-left:auto;margin-right:auto;':f.ha==='right'?'margin-left:auto;':''}">` : ''}<div class="cellval${cellClasses(f)}"${cs?` style="${cs}"`:''}>${esc(display)}</div></td>`;
    }
    rowsHtml += '</tr>';
  }
  return `
  <div class="crumb" id="backToSheets">← Semua Tabel</div>
  <div class="section-title">📊 ${esc(sheet.name)}</div>
  <div class="section-sub">Klik sel untuk mengisi. Rumus: =SUM(A1:A5), =AVERAGE, =MIN, =MAX, =COUNT, =COUNTA, =MEDIAN, =PRODUCT, atau =A1+B1 (atau pakai tombol Σ). Format (B/I/U, warna, Rupiah, dll.) berlaku untuk sel terpilih: klik sel, Shift+klik untuk rentang, atau klik huruf kolom / nomor baris.</div>
  <div class="sheet-toolbar">
    <button class="btn small ghost" id="btnAddRow" title="Sisipkan baris di bawah sel terpilih (atau di akhir)">+ Baris</button>
    <button class="btn small ghost" id="btnAddCol" title="Sisipkan kolom di kanan sel terpilih (atau di akhir)">+ Kolom</button>
    <button class="btn small ghost" id="btnDelRow" title="Hapus baris sel terpilih (tanpa pilihan: baris terakhir)">− Baris</button>
    <button class="btn small ghost" id="btnDelCol" title="Hapus kolom sel terpilih (tanpa pilihan: kolom terakhir)">− Kolom</button>
    <button class="btn small ghost" id="btnRenameSheet">Ganti Nama</button>
    <button class="btn small ghost" id="btnExport">⬆ Export</button>
    <button class="btn small danger" id="btnDelSheet">Hapus Tabel</button>
  </div>
  <div class="rtb stick${tbOpen.sheet?' tb-open':''}" id="shTb">
    <button type="button" class="tb" id="shUndo" title="Undo (Ctrl+Z)" aria-label="Undo" disabled>${IC.undo}</button>
    <button type="button" class="tb" id="shRedo" title="Redo (Ctrl+Y / Ctrl+Shift+Z)" aria-label="Redo" disabled>${IC.redo}</button>
    <button type="button" class="tb tb-x" id="fmtPaint" title="Salin format: tekan, pilih sel tujuan, tekan lagi" aria-label="Salin format">${IC.brush}</button>
    <span class="tb-sep tb-x"></span>
    <button type="button" class="tb wide tb-x" id="fmtFont" title="Jenis font"><span id="fmtFontLbl">Inter</span><span>▾</span></button>
    <span class="tb-size tb-x"><button type="button" class="tb" id="fsDown" title="Kecilkan font">−</button><button type="button" class="tb num" id="fsVal" title="Ukuran font">13</button><button type="button" class="tb" id="fsUp" title="Besarkan font">+</button></span>
    <span class="tb-sep"></span>
    <button type="button" class="tb" id="fmtB" title="Tebal (Ctrl+B)"><b>B</b></button>
    <button type="button" class="tb" id="fmtI" title="Miring (Ctrl+I)"><i>I</i></button>
    <button type="button" class="tb" id="fmtU" title="Garis bawah (Ctrl+U)"><u>U</u></button>
    <button type="button" class="tb tb-x" id="fmtS" title="Coret"><s>S</s></button>
    <button type="button" class="tb tb-color" id="fmtColor" title="Warna teks" aria-label="Warna teks"><span style="font-weight:700;line-height:1">A</span><span class="bar" id="barColor"></span></button>
    <button type="button" class="tb tb-color" id="fmtFill" title="Warna latar sel" aria-label="Warna latar sel">${IC.fill}<span class="bar" id="barFill"></span></button>
    <button type="button" class="tb tb-x" id="fmtBorder" title="Batas / border sel" aria-label="Border">${IC.border}</button>
    <span class="tb-sep tb-x"></span>
    <button type="button" class="tb tb-x" data-ha="left" title="Rata kiri" aria-label="Rata kiri">${IC.alL}</button>
    <button type="button" class="tb tb-x" data-ha="center" title="Rata tengah" aria-label="Rata tengah">${IC.alC}</button>
    <button type="button" class="tb tb-x" data-ha="right" title="Rata kanan" aria-label="Rata kanan">${IC.alR}</button>
    <button type="button" class="tb tb-x" id="fmtVA" title="Rata vertikal" aria-label="Rata vertikal">${IC.valign}</button>
    <span class="tb-sep tb-x"></span>
    <button type="button" class="tb tb-x" id="fmtNF" title="Format angka (Rupiah, persen, dll.)">123 ▾</button>
    <button type="button" class="tb tb-x" id="decDown" title="Kurangi angka desimal">.0←</button>
    <button type="button" class="tb tb-x" id="decUp" title="Tambah angka desimal">.00→</button>
    <span class="tb-sep tb-x"></span>
    <button type="button" class="tb tb-x" id="fmtDelContent" title="Hapus isi sel terpilih (tabel & format tetap)" aria-label="Hapus isi sel">${IC.clear}</button>
    <button type="button" class="tb tb-x" id="fmtClear" title="Hapus format sel yang dipilih">Bersihkan</button>
    <span class="tb-sep"></span>
    <button type="button" class="tb" id="fnSum" title="Sisipkan rumus (jumlah, rata-rata, dll.)" aria-label="Rumus"><b style="font-size:1.05rem">Σ</b><span>▾</span></button>
    <button type="button" class="tb${flt?' on':''}" id="fltToggle" title="Aktifkan / matikan filter kolom" aria-label="Filter">${IC.filter}</button>
    <button type="button" class="tb" id="shPhoto" title="Tambah foto di bawah tabel" aria-label="Tambah foto">${IC.image}<span>Foto</span></button>
    <input type="file" id="shPhotoFile" accept="image/*" multiple hidden>
    <button type="button" class="tb${sheetMulti?' on':''}" id="btnMulti" title="Aktifkan, lalu ketuk beberapa sel untuk memilihnya (di komputer bisa Shift+klik)">☑ Pilih banyak</button>
    <button type="button" class="tb tb-more" id="tbMore" title="Menu format lainnya" aria-label="Menu format lainnya">⋯</button>
    <span class="fmt-info" id="selInfo"></span>
  </div>
  ${flt ? `<div class="flt-banner"><span>🔎 Filter aktif · menampilkan ${ro.order.length} dari ${sheet.rows} baris · baris 1 dianggap judul. Pakai tombol ▾ di huruf kolom.</span><button type="button" class="btn small ghost" id="fltClearAll">Hapus semua filter</button></div>` : ''}
  <div class="sheet-wrap"><table class="sheet"><thead>${thead}</thead><tbody>${rowsHtml}</tbody></table></div>${photosHtml(sheet)}`;
}
function photosHtml(sheet){
  const ph = sheet.photos || []; if(!ph.length) return '';
  ph.forEach(p=>shPool.set(p.id, p.src));
  return `<div class="sh-photos"><h4>🖼 Foto (${ph.length})</h4><div class="sh-ph-list">${ph.map(p=>`<figure class="sh-ph" style="width:${p.w===100?'100%':p.w===33?'min(100%,240px)':'min(100%,480px)'}"><img src="${p.src}" alt="Foto tabel"><div class="img-actions">${[[33,'Kecil'],[66,'Sedang'],[100,'Penuh']].map(([w,l])=>`<button type="button" data-phw="${p.id}:${w}"${(p.w||66)===w?' class="on"':''}>${l}</button>`).join('')}<button type="button" data-phdel="${p.id}" style="background:#dc2626">Hapus</button></div></figure>`).join('')}</div></div>`;
}
function wireSheetDetail(){
  const $ = id => document.getElementById(id);
  $('backToSheets').addEventListener('click', ()=>{ closePops(); view='sheets'; activeSheetId=null; curSheet=null; render(); });
  const tb = $('shTb');
  tb.querySelectorAll('button').forEach(b=>b.addEventListener('mousedown', e=>e.preventDefault()));   // klik toolbar tidak mencuri fokus dari sel
  $('tbMore').addEventListener('click', ()=>{ tbOpen.sheet = !tbOpen.sheet; tb.classList.toggle('tb-open', tbOpen.sheet); });
  $('shUndo').addEventListener('click', ()=>sheetStep('undo'));
  $('shRedo').addEventListener('click', ()=>sheetStep('redo'));
  updateUndoButtons();
  $('fmtPaint').addEventListener('click', sheetBrush);
  $('fmtB').addEventListener('click', ()=>applySheetFormat('b'));
  $('fmtI').addEventListener('click', ()=>applySheetFormat('i'));
  $('fmtU').addEventListener('click', ()=>applySheetFormat('u'));
  $('fmtS').addEventListener('click', ()=>applySheetFormat('x'));
  $('fmtClear').addEventListener('click', ()=>applySheetFormat(null));
  $('fmtDelContent').addEventListener('click', clearContents);
  $('btnMulti').addEventListener('click', ()=>{ sheetMulti = !sheetMulti; applySelClasses(); });
  let photoKeys = [];
  $('shPhoto').addEventListener('click', ()=>{
    if(!sheetSel.size){ toast('Pilih sel dulu, lalu tekan Foto'); return; }
    photoKeys = [...sheetSel];
    const has = photoKeys.some(k=>fmtOf(k).img);
    const items = [{v:'pick', label:has ? '🖼 Ganti foto…' : '🖼 Pilih foto…'}];
    if(has) items.push({v:'L', label:'⬅ Rata kiri'}, {v:'C', label:'↔ Di tengah'}, {v:'R', label:'➡ Rata kanan'}, {v:'s', label:'Ukuran kecil'}, {v:'m', label:'Ukuran sedang'}, {v:'l', label:'Ukuran besar'}, {v:'del', label:'✕ Hapus foto'});
    menuPop($('shPhoto'), items, null, v=>{
      if(v === 'pick') $('shPhotoFile').click();
      else if(v === 'del') applyFmt(f=>{ delete f.img; delete f.iw; });
      else if(v === 'L' || v === 'C' || v === 'R') applyFmt(f=>{ if(v === 'L') delete f.ha; else f.ha = v === 'C' ? 'center' : 'right'; });   // sama dengan tombol rata teks: foto dan teks sel ikut
      else applyFmt(f=>{ if(f.img) f.iw = {s:48, m:96, l:180}[v]; });
    });
  });
  $('shPhotoFile').addEventListener('change', async e=>{
    const f0 = e.target.files[0]; e.target.value = ''; if(!f0) return;
    if(!/^image\//.test(f0.type) || f0.size > 25*1024*1024){ toast('Foto tidak bisa dibaca. Pilih file gambar (JPG/PNG/WebP), maksimal 25 MB.', 4500); return; }
    toast('Memproses foto…');
    let src; try{ src = await photoToDataUrl(f0, 480, 0.72); }catch(err){ toast('Foto tidak bisa dibaca.', 4000); return; }
    const id = 'ci' + Math.random().toString(36).slice(2);
    // Foto besar butuh waktu diproses; selama itu pengguna mungkin sudah pindah ke sel lain dan mulai mengetik.
    // Jadi JANGAN commitEdit()/render() ulang seluruh tabel (itu menutup editor sel yang sedang dibuka).
    // Simpan lewat mutateSheet saja, lalu ubah hanya <td> sel foto di DOM.
    const keys = photoKeys.slice();
    const selfEdit = !!(editing && keys.includes(editing.key));    // sel foto itu sendiri sedang diketik: simpan dulu teksnya
    if(selfEdit) await commitEdit(false);
    await mutateSheet(sh=>{
      sh.imgs = sh.imgs || {}; sh.imgs[id] = src; sh.fmt = sh.fmt || {};
      keys.forEach(k=>{ const f = sh.fmt[k] || (sh.fmt[k] = {}); f.img = id; if(!f.iw) f.iw = 96; });
    });
    if(curSheet){ curSheet.imgs = curSheet.imgs || {}; curSheet.imgs[id] = src; curSheet.fmt = curSheet.fmt || {}; keys.forEach(k=>{ const f = curSheet.fmt[k] || (curSheet.fmt[k] = {}); f.img = id; if(!f.iw) f.iw = 96; }); }
    if(selfEdit){ await render(); toast('Foto dimasukkan ke ' + keys.length + ' sel'); return; }
    keys.forEach(k=>{
      const td = document.querySelector('table.sheet td[data-key="'+k+'"]'); if(!td) return;
      const f = fmtOf(k); td.querySelectorAll('img.cellimg').forEach(n=>n.remove());
      const im = document.createElement('img'); im.className = 'cellimg'; im.alt = 'Foto sel'; im.src = imgUrl(id, src);
      im.style.height = (f.iw||96) + 'px';
      if(f.ha === 'center'){ im.style.marginLeft = 'auto'; im.style.marginRight = 'auto'; } else if(f.ha === 'right') im.style.marginLeft = 'auto';
      td.insertBefore(im, td.firstChild);
    });
    toast('Foto dimasukkan ke ' + keys.length + ' sel');
  });
  document.querySelectorAll('[data-phw]').forEach(b=>b.addEventListener('click', async()=>{
    const [id,w] = b.dataset.phw.split(':'); await mutateSheet(sh=>{ const p=(sh.photos||[]).find(x=>x.id===id); if(p) p.w = +w; }); render();
  }));
  document.querySelectorAll('[data-phdel]').forEach(b=>b.addEventListener('click', async()=>{
    const id = b.dataset.phdel; await mutateSheet(sh=>{ sh.photos = (sh.photos||[]).filter(x=>x.id!==id); }); render();
  }));
  const first = () => { const k = [...sheetSel][0]; return k ? fmtOf(k) : {}; };
  $('fmtFont').addEventListener('click', ()=>menuPop($('fmtFont'), FONTS.map(f=>({v:f, label:f, style:`font-family:'${f}',sans-serif`})), first().ff || 'Inter', f=>setFmtProp('ff', f === 'Inter' ? null : f)));
  $('fsDown').addEventListener('click', ()=>stepSize(-1));
  $('fsUp').addEventListener('click', ()=>stepSize(1));
  $('fsVal').addEventListener('click', ()=>menuPop($('fsVal'), FONT_SIZES.map(x=>({v:x, label:String(x)})), first().fs || 13, x=>setFmtProp('fs', x === 13 ? null : x)));
  $('fmtColor').addEventListener('click', ()=>colorPop($('fmtColor'), c=>setFmtProp('c', c), 'Otomatis (ikut tema)'));
  $('fmtFill').addEventListener('click', ()=>colorPop($('fmtFill'), c=>setFmtProp('bg', c), 'Tanpa warna latar'));
  $('fmtBorder').addEventListener('click', ()=>menuPop($('fmtBorder'), [
    {v:'all', label:'▦ Semua batas'}, {v:'outer', label:'▢ Batas luar'}, {v:'bottom', label:'▁ Batas bawah'}, {v:'top', label:'▔ Batas atas'},
    {v:'left', label:'▏ Batas kiri'}, {v:'right', label:'▕ Batas kanan'}, {v:'none', label:'✕ Hapus batas'}], null, k=>applyBorder(k)));
  tb.querySelectorAll('[data-ha]').forEach(b=>b.addEventListener('click', ()=>setFmtProp('ha', b.dataset.ha === 'left' && !first().nf ? null : b.dataset.ha)));
  $('fmtVA').addEventListener('click', ()=>menuPop($('fmtVA'), [{v:'top', label:'Atas'}, {v:'middle', label:'Tengah'}, {v:'bottom', label:'Bawah'}], first().va || null, v=>setFmtProp('va', v)));
  $('fmtNF').addEventListener('click', ()=>menuPop($('fmtNF'), [
    {v:'', label:'Otomatis'}, {v:'number', label:'Angka  (1.234,5)'}, {v:'rupiah', label:'Rupiah  (Rp1.500.000)'}, {v:'percent', label:'Persen  (25%)'}], first().nf || '', v=>setNumFmt(v)));
  $('fnSum').addEventListener('click', ()=>menuPop($('fnSum'), FUNCS.map(([v,l])=>({v, label:l})), null, v=>insertFunc(v)));
  $('fltToggle').addEventListener('click', toggleFilter);
  const fca = $('fltClearAll'); if(fca) fca.addEventListener('click', toggleFilter);
  document.querySelectorAll('[data-flt]').forEach(b=>{ b.addEventListener('mousedown', e=>e.stopPropagation()); b.addEventListener('click', e=>{ e.stopPropagation(); openFilterPop(b, Number(b.dataset.flt)); }); });
  $('decDown').addEventListener('click', ()=>stepDec(-1));
  $('decUp').addEventListener('click', ()=>stepDec(1));
  applySelClasses();
  document.querySelectorAll('table.sheet th[data-colsel]').forEach(th=>th.addEventListener('click', ()=>{
    const c = Number(th.dataset.colsel), n = document.querySelectorAll('table.sheet tbody tr').length;
    sheetSel = new Set(Array.from({length:n}, (_,r)=>cellKey(r,c))); sheetAnchor = cellKey(0,c); applySelClasses();
  }));
  document.querySelectorAll('table.sheet td[data-rowsel]').forEach(td=>td.addEventListener('click', ()=>{
    const r = Number(td.dataset.rowsel), n = document.querySelectorAll('table.sheet thead th[data-colsel]').length;
    sheetSel = new Set(Array.from({length:n}, (_,c)=>cellKey(r,c))); sheetAnchor = cellKey(r,0); applySelClasses();
  }));
  document.querySelectorAll('table.sheet td[data-key] .cellval').forEach(div=>{
    div.addEventListener('click', async e=>{
      const td = div.parentElement; const key = td.dataset.key;
      if(e.shiftKey && sheetAnchor){ selectRange(sheetAnchor, key); applySelClasses(); return; }
      if(sheetMulti){ if(sheetSel.has(key)) sheetSel.delete(key); else sheetSel.add(key); sheetAnchor = key; applySelClasses(); return; }
      sheetSel = new Set([key]); sheetAnchor = key; applySelClasses();
      const sheet = await get('sheets', activeSheetId);
      const raw = (sheet.cells && sheet.cells[key]) || '';
      const f = (sheet.fmt && sheet.fmt[key]) || {};
      td.classList.add('editing');
      const cs = cellCss(f);
      td.innerHTML = `<input type="text" class="${cellClasses(f).trim()}"${cs?` style="${cs}"`:''} value="${esc(raw)}">`;
      const inp = td.querySelector('input'); inp.focus(); inp.select();
      editing = {key, inp, raw};
      const fit = ()=>{ const need = Math.ceil((inp.value.length + 1) * 7.8 + 22); inp.style.width = need > td.offsetWidth ? need + 'px' : ''; };
      inp.addEventListener('input', fit); inp.addEventListener('input', sheetAutosaveSoon); fit();   // melebar hanya kalau teks lebih panjang dari sel
      inp.addEventListener('keydown', e2=>{
        const k = (e2.key||'').toLowerCase();
        if((e2.ctrlKey||e2.metaKey) && (k==='b'||k==='i'||k==='u')){ e2.preventDefault(); applySheetFormat(k); return; }
        // stopPropagation: Enter/Esc di dalam sel hanya menutup editor; jangan diteruskan ke pintasan keyboard Tabel (Enter = mulai edit sel terpilih), kalau tidak sel yang baru selesai langsung terbuka lagi
        if(e2.key==='Enter'){ e2.preventDefault(); e2.stopPropagation(); inp.blur(); }
        if(e2.key==='Escape'){ e2.stopPropagation(); inp.value = raw; inp.blur(); }
      });
      inp.addEventListener('blur', ()=>{ if(editing && editing.inp===inp) commitEdit(true); }, {once:true});
    });
  });
  $('btnAddRow').addEventListener('click', ()=>sheetInsert('row'));
  $('btnAddCol').addEventListener('click', ()=>sheetInsert('col'));
  $('btnDelRow').addEventListener('click', ()=>sheetDelete('row'));
  $('btnDelCol').addEventListener('click', ()=>sheetDelete('col'));
  $('btnExport').addEventListener('click', e=>{
    e.stopPropagation();
    document.querySelectorAll('.menu-pop').forEach(m=>m.remove());
    const rect = e.currentTarget.getBoundingClientRect();
    const pop = document.createElement('div');
    pop.className = 'menu-pop';
    pop.style.position = 'fixed'; pop.style.right='auto';
    pop.style.top = (rect.bottom + 6) + 'px';
    pop.style.left = rect.left + 'px';
    pop.innerHTML = `<button data-exp="memo">📋 Salin ke Memo</button><button data-exp="csv">⬇️ Download CSV</button><button data-exp="pdf">📄 Download PDF</button>`;
    document.body.appendChild(pop);
    pop.querySelector('[data-exp="memo"]').onclick = async ()=>{
      pop.remove();
      await commitEdit(false);
      const sheet = await get('sheets', activeSheetId);
      const header = Array.from({length:sheet.cols},(_,c)=>colLetter(c));
      const fm = sheet.fmt || {};
      const rows = computeDisplayGrid(sheet).map((row,r)=>row.map((v,c)=>cellToHtml(v, fm[cellKey(r,c)])));
      const blocks = [{type:'text', html:'<p></p>'}, {type:'table', header, rows, rich:true}, {type:'text', html:'<p></p>'}];
      memoDraft = {title:`Tabel: ${sheet.name}`, blocks, date:todayISO(), fromSheet:{id:sheet.id, name:sheet.name}};
      toast('Tabel disalin. Tambahkan catatan jika perlu, lalu tekan Simpan agar masuk ke Memo.', 4500);
      activeMemoId=null; memoUid=null; activeSheetId=null; curSheet=null; view='memo-editor'; render();
    };
    pop.querySelector('[data-exp="csv"]').onclick = async ()=>{
      pop.remove();
      await commitEdit(false);
      const sheet = await get('sheets', activeSheetId);
      const fname = (sheet.name||'tabel').replace(/[^a-zA-Z0-9 _-]/g,'').trim().replace(/\s+/g,'_') || 'tabel';
      await tryDownloadsSave(fname+'.csv', sheetToCSV(sheet));
    };
    pop.querySelector('[data-exp="pdf"]').onclick = async ()=>{
      pop.remove();
      await commitEdit(false);
      const sheet = await get('sheets', activeSheetId);
      const fname = (sheet.name||'tabel').replace(/[^a-zA-Z0-9 _-]/g,'').trim().replace(/\s+/g,'_') || 'tabel';
      const blob = sheetToPDFBlob(sheet);
      if(!blob){ toast('Gagal memuat pembuat PDF, coba lagi'); return; }
      await tryDownloadsSave(fname+'.pdf', blob);
    };
    setTimeout(()=>document.addEventListener('click', function close(ev){ if(!pop.contains(ev.target)){ pop.remove(); document.removeEventListener('click', close); } }), 10);
  });
  $('btnRenameSheet').addEventListener('click', async ()=>{
    const s=await get('sheets',activeSheetId);
    const html = `<div class="overlay" id="ovRen"><div class="modal"><h3>Ganti Nama Tabel</h3><div class="field"><input id="ren_name" value="${esc(s.name)}"></div><div class="modal-actions"><button class="btn ghost" id="renAnc">Batal</button><button class="btn" id="renOk">Simpan</button></div></div></div>`;
    document.body.insertAdjacentHTML('beforeend', html);
    attachAutoCapitalize(document.getElementById('ren_name'));
    document.getElementById('renAnc').onclick=()=>document.getElementById('ovRen').remove();
    document.getElementById('renOk').onclick=async ()=>{
      const name = document.getElementById('ren_name').value.trim();
      if(!name){ toast('Nama tidak boleh kosong'); return; }
      s.name=name; await put('sheets',s); markWrite(); document.getElementById('ovRen').remove(); render();
    };
  });
  $('btnDelSheet').addEventListener('click', ()=>{
    confirmModal('Hapus Tabel?','Seluruh isi tabel ini akan dihapus permanen.', async ()=>{
      await del('sheets', activeSheetId); markWrite(); view='sheets'; activeSheetId=null; curSheet=null; toast('Tabel dihapus'); render();
    });
  });
}

async function pageSearch(){
  const q = searchQuery.toLowerCase();
  const qDigits = digitsOnly(searchQuery);
  const [folders, prods] = await Promise.all([all('folders'), all('products')]);
  const fMatch = folders.filter(f=>f.name.toLowerCase().includes(q));
  const pMatch = prods.filter(p=>
    p.name.toLowerCase().includes(q) ||
    fmtDate(p.date).toLowerCase().includes(q) ||
    (folders.find(f=>f.id===p.folderId)||{}).name?.toLowerCase().includes(q) ||
    (qDigits && (String(p.price).includes(qDigits) || String(p.sellingPrice).includes(qDigits)))
  );
  const folderName = id => (folders.find(f=>f.id===id)||{}).name || '-';
  return `
  <div class="section-title">Hasil Pencarian</div>
  <div class="section-sub">"${esc(searchQuery)}"</div>
  <div class="search-result-group"><h4>Folder (${fMatch.length})</h4>
    ${fMatch.map(f=>`<div class="sres-item" data-open="${f.id}"><span>📁 ${esc(f.name)}</span><span style="color:var(--muted);font-size:.76rem">buka →</span></div>`).join('') || '<div class="empty">Tidak ada folder cocok.</div>'}
  </div>
  <div class="search-result-group"><h4>Barang (${pMatch.length})</h4>
    ${pMatch.map(p=>`<div class="sres-item" data-openf="${p.folderId}"><span>📦 ${esc(p.name)} <span style="color:var(--muted);font-size:.76rem">· ${esc(folderName(p.folderId))}</span></span><span style="font-weight:600;font-size:.82rem">${rupiah(p.price)}</span></div>`).join('') || '<div class="empty">Tidak ada barang cocok.</div>'}
  </div>`;
}
function wireSearchExtra(){
  document.querySelectorAll('#content [data-open]').forEach(el=>{ if(el._wo) return; el._wo = 1; el.addEventListener('click', ()=>{ document.getElementById('globalSearch').value=''; searchQuery=''; openFolder(Number(el.dataset.open)); }); });
  document.querySelectorAll('#content [data-openf]').forEach(el=>el.addEventListener('click', ()=>{ document.getElementById('globalSearch').value=''; searchQuery=''; openFolder(Number(el.dataset.openf)); }));
}

/* patch render to wire dashboard/search extras after innerHTML set */
const _render = render;
render = async function(){
  if(memoAS && memoAS.active){ await memoAS.flush(); memoAS.close(); memoAS = null; }   // simpan memo yang sedang ditulis sebelum layar berganti
  await _render(); wireDashboardExtra(); wireSearchExtra();
  closePops(); setTbHeight();
};
function setTbHeight(){ const t = document.querySelector('.topbar'); if(t) document.documentElement.style.setProperty('--tbh', t.offsetHeight + 'px'); }
window.addEventListener('resize', setTbHeight);

/* ---------------- modals ---------------- */
function confirmModal(title, msg, onConfirm, target, okLabel){
  const html = `<div class="overlay" id="ovConfirm"><div class="modal confirm">
    <h3>${title}</h3>
    ${target?`<div class="target">${esc(target)}</div>`:''}
    <p>${msg}</p>
    <div class="modal-actions"><button class="btn ghost" id="cAnc">Batal</button><button class="btn danger" id="cOk">${esc(okLabel || 'Hapus')}</button></div>
  </div></div>`;
  document.body.insertAdjacentHTML('beforeend', html);
  document.getElementById('cAnc').onclick = ()=>document.getElementById('ovConfirm').remove();
  document.getElementById('cOk').onclick = async ()=>{ document.getElementById('ovConfirm').remove(); await onConfirm(); };
}

function openFolderModal(){
  const html = `<div class="overlay" id="ovFolder"><div class="modal">
    <h3>Buat Folder Baru</h3>
    <div class="field"><label>Nama Folder</label><input id="fld_name" placeholder="Contoh: 23 September 2026"></div>
    <div class="modal-actions"><span class="save-status" id="f_status">Tersimpan otomatis saat kamu mengetik</span><button class="btn ghost" id="fAnc">Batal</button><button class="btn" id="fOk">Buat Folder</button></div>
  </div></div>`;
  document.body.insertAdjacentHTML('beforeend', html);
  attachAutoCapitalize(document.getElementById('fld_name'));
  let createdAt = null;
  const stat = s => { const el = document.getElementById('f_status'); if(!el) return; el.textContent = s === 'pending' ? 'Menyimpan otomatis…' : s === 'saved' ? '✓ Tersimpan otomatis' : s === 'error' ? '⚠ Gagal menyimpan otomatis' : el.textContent; };
  const fAS = makeAutosave({store:'folders', onState:stat, build:()=>{
    const name = (document.getElementById('fld_name') || {value:''}).value.trim();
    if(!name) return null;
    if(!createdAt) createdAt = Date.now();
    return {name, createdAt, lastOpenedAt:0};
  }});
  document.getElementById('fld_name').addEventListener('input', ()=>fAS.schedule());
  const closeModal = ()=>{ const o = document.getElementById('ovFolder'); if(o) o.remove(); };
  document.getElementById('fAnc').onclick = ()=>{
    if(!fAS.dirty()){ fAS.close(); closeModal(); return; }
    confirmModal('Buang folder ini?', 'Folder yang baru diketik ini akan dihapus lagi.', async()=>{ await fAS.discard(); closeModal(); render(); }, null, 'Buang');
  };
  document.getElementById('fOk').onclick = async ()=>{
    const name = document.getElementById('fld_name').value.trim();
    if(!name){ toast('Nama folder wajib diisi'); return; }
    try{
      const ok = await fAS.finish();                                      // COMMIT (simpan keadaan terakhir)
      if(!ok) throw new Error('save');
      await logActivity('add','folder', name);
      toast('Folder dibuat'); closeModal(); render();
    }catch(e){ toast('Gagal membuat folder (ROLLBACK)'); }
  };
}

async function openProductModal(id){
  let p = id ? (await all('products')).find(x=>x.id === id) : {date:todayISO(), name:'', price:0, boxQty:'', smallBoxQty:'', sellingPrice:0};
  if(p && p.hasPhoto && !p.photo){ try{ p = await get('products', id); }catch(e){ toast('Gagal memuat foto barang, coba lagi'); return; } }   // daftar barang tanpa foto: ambil lengkap sebelum diedit supaya foto tidak hilang saat disimpan
  const html = `<div class="overlay" id="ovProd"><div class="modal">
    <h3>${id?'Edit Barang':'Tambah Barang'}</h3>
    <div class="field"><label>Tanggal</label><input id="p_date" type="date" value="${p.date}"></div>
    <div class="field"><label>Nama Barang</label><input id="p_name" value="${esc(p.name)}"></div>
    <div class="field"><label>Harga Barang</label><input id="p_price" type="text" placeholder="0" value="${p.price?formatThousands(String(p.price)):''}"></div>
    <div class="field-row">
      <div class="field"><label>Isi Dus <span style="font-weight:500;opacity:.7">(angka saja)</span></label><input id="p_box" type="text" inputmode="numeric" placeholder="Contoh: 12" value="${esc(String(p.boxQty ?? '').replace(/\D/g,''))}"></div>
      <div class="field"><label>Isi / Box Kecil / Pcs</label><input id="p_sbox" type="number" min="0" value="${p.smallBoxQty ?? ''}"></div>
    </div>
    <div class="field"><label>Harga Jual</label><input id="p_sell" type="text" placeholder="0" value="${p.sellingPrice?formatThousands(String(p.sellingPrice)):''}"></div>
    <div class="field">
      <label>Foto (opsional)</label>
      <div class="photo-input-wrap" id="photoWrap"></div>
    </div>
    <div class="modal-actions"><span class="save-status" id="p_status">Tersimpan otomatis saat kamu mengisi</span><button class="btn ghost" id="pAnc">Batal</button><button class="btn" id="pOk">Simpan</button></div>
  </div></div>`;
  document.body.insertAdjacentHTML('beforeend', html);
  let photoData = p.photo || null;
  function renderPhotoWrap(){
    const wrap = document.getElementById('photoWrap');
    wrap.innerHTML = photoData
      ? `<img class="photo-preview" src="${photoData}"><div class="photo-actions"><button type="button" class="btn small ghost" id="btnChangePhoto">Ganti Foto</button><button type="button" class="btn small danger" id="btnRemovePhoto">Hapus Foto</button></div><input type="file" id="p_photo" accept="image/*" style="display:none;">`
      : `<div style="font-size:.8rem;color:var(--muted);margin-bottom:8px;">📷 Belum ada foto</div><button type="button" class="btn small ghost" id="btnChangePhoto">Pilih dari Galeri</button><input type="file" id="p_photo" accept="image/*" style="display:none;">`;
    document.getElementById('btnChangePhoto').addEventListener('click', ()=>document.getElementById('p_photo').click());
    const rb = document.getElementById('btnRemovePhoto');
    if(rb) rb.addEventListener('click', ()=>{ photoData=null; renderPhotoWrap(); pAS.schedule(); });
    document.getElementById('p_photo').addEventListener('change', e=>{
      const file = e.target.files[0];
      if(!file) return;
      if(!/^image\//.test(file.type) || file.size > 25*1024*1024){ toast('Pilih file gambar, maksimal 25MB'); return; }
      // Foto barang diperkecil (maks 800px) supaya daftar barang & halaman lain tetap ringan; foto asli kamera bisa beberapa MB.
      photoToDataUrl(file, 800, 0.78).then(src=>{ photoData = src; renderPhotoWrap(); pAS.schedule(); }).catch(()=>toast('Foto tidak bisa dibaca.'));
    });
  }
  renderPhotoWrap();
  attachRupiahInput(document.getElementById('p_price'));
  attachRupiahInput(document.getElementById('p_sell'));
  document.getElementById('p_box').addEventListener('input', e=>{ e.target.value = e.target.value.replace(/\D/g,''); });
  attachAutoCapitalize(document.getElementById('p_name'));
  const pStat = s => { const el = document.getElementById('p_status'); if(!el) return; el.textContent = s === 'pending' ? 'Menyimpan otomatis…' : s === 'saved' ? '✓ Tersimpan otomatis' : s === 'error' ? '⚠ Gagal menyimpan otomatis' : el.textContent; };
  const pAS = makeAutosave({store:'products', id:id || null, original:id ? JSON.parse(JSON.stringify(p)) : null, onState:pStat, build:()=>{
    const g = k => document.getElementById(k);
    if(!g('p_name')) return null;
    const name = g('p_name').value.trim(), date = g('p_date').value;
    if(!name || !date) return null;                                    // nama & tanggal wajib: sebelum itu belum disimpan
    const boxRaw = g('p_box').value.replace(/\D/g,''), sboxRaw = g('p_sbox').value;
    if(!p.createdAt) p.createdAt = Date.now();
    return { folderId:activeFolderId, date, name, price:parseRupiah(g('p_price').value), boxQty: boxRaw===''?null:Number(boxRaw), smallBoxQty: sboxRaw===''?null:Number(sboxRaw), sellingPrice:parseRupiah(g('p_sell').value), photo:photoData, createdAt:p.createdAt, updatedAt:Date.now() };
  }});
  pAS.baseline();
  document.getElementById('ovProd').addEventListener('input', ()=>pAS.schedule());
  document.getElementById('ovProd').addEventListener('change', ()=>pAS.schedule());
  document.getElementById('pAnc').onclick = ()=>{
    const closeModal = ()=>{ const o = document.getElementById('ovProd'); if(o) o.remove(); };
    if(!pAS.dirty()){ pAS.close(); closeModal(); return; }
    confirmModal('Buang perubahan?', id ? 'Perubahan pada barang ini akan dibatalkan dan datanya kembali seperti semula.' : 'Barang yang baru diisi ini tidak akan disimpan.', async()=>{ await pAS.discard(); closeModal(); render(); }, null, 'Buang');
  };
  document.getElementById('pOk').onclick = async ()=>{
    const name = document.getElementById('p_name').value.trim();
    const date = document.getElementById('p_date').value;
    const price = parseRupiah(document.getElementById('p_price').value);
    const sell = parseRupiah(document.getElementById('p_sell').value);
    const boxRaw = document.getElementById('p_box').value.replace(/\D/g,'');
    const sboxRaw = document.getElementById('p_sbox').value;
    if(!name){ toast('Nama barang wajib diisi'); return; }
    if(!date){ toast('Tanggal wajib diisi'); return; }
    if(price < 0){ toast('Harga barang tidak boleh negatif'); return; }
    if(sell < 0){ toast('Harga jual tidak boleh negatif'); return; }
    if(boxRaw!=='' && Number(boxRaw)<0){ toast('Isi dus tidak boleh negatif'); return; }
    if(sboxRaw!=='' && Number(sboxRaw)<0){ toast('Isi box kecil tidak boleh negatif'); return; }
    try{
      const ok = await pAS.finish(); // COMMIT (menyimpan keadaan terakhir; sebagian besar sudah tersimpan otomatis)
      if(!ok) throw new Error('save');
      await logActivity(id?'edit':'add','product', name);
      markWrite(); toast(id?'Perubahan disimpan':'Barang ditambahkan');
      document.getElementById('ovProd').remove(); render();
    }catch(e){ toast('Gagal menyimpan (ROLLBACK)'); }
  };
}

/* ---------------- theme picker ---------------- */
const THEMES = [
  {id:'light', label:'Terang', c:'#F8FAFC'},
  {id:'dark', label:'Gelap', c:'#0F172A'},
  {id:'blue', label:'Biru', c:'#2563EB'},
  {id:'green', label:'Hijau', c:'#16A34A'},
  {id:'sunset', label:'Sunset', c:'#F97316'},
];
function applyTheme(id){
  document.documentElement.setAttribute('data-theme', id);
  try{ localStorage.setItem('catatin_theme', id); }catch(e){}
}
(function initTheme(){
  let saved = 'light';
  try{ saved = localStorage.getItem('catatin_theme') || 'light'; }catch(e){}
  applyTheme(saved);
})();
document.getElementById('themeBtn').addEventListener('click', e=>{
  document.querySelectorAll('.theme-pop').forEach(p=>p.remove());
  let current='light'; try{ current = localStorage.getItem('catatin_theme')||'light'; }catch(err){}
  const rect = e.currentTarget.getBoundingClientRect();
  const pop = document.createElement('div');
  pop.className='theme-pop';
  pop.style.top = (rect.bottom+8)+'px';
  pop.style.right = (window.innerWidth-rect.right)+'px';
  pop.innerHTML = `<h5>Pilih Tema</h5>` + THEMES.map(t=>`<div class="theme-opt ${current===t.id?'sel':''}" data-t="${t.id}"><span class="swatch" style="background:${t.c}"></span>${t.label}</div>`).join('');
  document.body.appendChild(pop);
  pop.querySelectorAll('[data-t]').forEach(el=>el.addEventListener('click', ()=>{ applyTheme(el.dataset.t); pop.remove(); }));
  setTimeout(()=>document.addEventListener('click', function close(ev){ if(!pop.contains(ev.target) && ev.target.id!=='themeBtn'){ pop.remove(); document.removeEventListener('click', close); } }), 10);
});

/* ---------------- init ---------------- */
(async function init(){
  try{ await openDB(); await seedIfEmpty(); render(); }
  catch(e){ document.getElementById('content').innerHTML = '<div class="empty">Gagal memuat database lokal. Muat ulang halaman.</div>'; }
})();
</script>
</body>
</html>

@endverbatim
