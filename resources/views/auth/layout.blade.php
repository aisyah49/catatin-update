<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#3B82F6">
<title>@yield('title') — Catatin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}
:root{--blue:#3B82F6;--blue-d:#1E3A8A;--ink:#1E293B;--muted:#64748B;--line:#E2E8F0;--bg:#F8FAFC}
body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;color:var(--ink);
  font-family:'Inter',system-ui,sans-serif;background:linear-gradient(135deg,#3B82F6 0%,#1E3A8A 100%)}
.card{width:100%;max-width:400px;background:#fff;border-radius:20px;padding:32px 28px;box-shadow:0 24px 60px rgba(15,23,42,.35)}
.logo{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:1.5rem;display:flex;align-items:center;gap:8px;margin-bottom:4px}
.sub{color:var(--muted);font-size:.92rem;margin:0 0 22px}
label{display:block;font-size:.82rem;font-weight:600;margin:14px 0 6px}
input[type=text],input[type=email],input[type=password]{width:100%;padding:12px 14px;border:1.5px solid var(--line);border-radius:12px;font-size:1rem;font-family:inherit;background:#fff;color:var(--ink);transition:border-color .15s,box-shadow .15s}
input:focus{outline:0;border-color:var(--blue);box-shadow:0 0 0 4px rgba(59,130,246,.15)}
.row{display:flex;align-items:center;gap:8px;margin-top:14px;font-size:.88rem;color:var(--muted)}
.row input{width:auto}
button{margin-top:20px;width:100%;padding:13px;border:0;border-radius:12px;background:var(--blue);color:#fff;font-size:1rem;font-weight:700;font-family:inherit;cursor:pointer;transition:background .15s,transform .05s}
button:hover{background:#2563EB}button:active{transform:scale(.99)}
.err{background:#FEF2F2;border:1px solid #FECACA;color:#B91C1C;padding:10px 12px;border-radius:10px;font-size:.86rem;margin-bottom:6px}
.err div+div{margin-top:4px}
.alt{text-align:center;margin-top:20px;font-size:.9rem;color:var(--muted)}
.alt a{color:var(--blue);font-weight:600;text-decoration:none}
.alt a:hover{text-decoration:underline}
</style>
</head>
<body>
<main class="card">
  <div class="logo">📓 Catatin</div>
  @yield('content')
</main>
</body>
</html>
