<?php

use App\Support\CatatinSetup;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Siapkan seluruh database otomatis (tabel, function, trigger, login). Aman dijalankan berulang kali.
Artisan::command('catatin:setup', function () {
    return CatatinSetup::run($this);
})->purpose('Siapkan database Catatin otomatis (tanpa import SQL)');
