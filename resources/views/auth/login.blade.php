@extends('auth.layout')
@section('title', 'Masuk')
@section('content')
<p class="sub">Masuk untuk membuka catatan gudangmu.</p>

@if ($errors->any())
  <div class="err">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
@endif

<form method="POST" action="/masuk">
  @csrf
  <label for="email">Email</label>
  <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="nama@email.com">

  <label for="password">Kata sandi</label>
  <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Kata sandi">

  <div class="row"><input type="checkbox" id="remember" name="remember" value="1"><label for="remember" style="margin:0;font-weight:500">Ingat saya di perangkat ini</label></div>

  <button type="submit">Masuk</button>
</form>

@if ($registerOpen)
  <div class="alt">Belum punya akun? <a href="/daftar">Daftar</a></div>
@endif
@endsection
