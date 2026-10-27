@extends('auth.layout')
@section('title', 'Daftar')
@section('content')
<p class="sub">Buat akun baru. Catatanmu hanya bisa dilihat olehmu.</p>

@if ($errors->any())
  <div class="err">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
@endif

<form method="POST" action="/daftar">
  @csrf
  <label for="name">Nama</label>
  <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama kamu">

  <label for="email">Email</label>
  <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com">

  <label for="password">Kata sandi (minimal 6 karakter)</label>
  <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="Kata sandi">

  <label for="password_confirmation">Ulangi kata sandi</label>
  <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang kata sandi">

  <button type="submit">Daftar &amp; Masuk</button>
</form>

<div class="alt">Sudah punya akun? <a href="/masuk">Masuk</a></div>
@endsection
