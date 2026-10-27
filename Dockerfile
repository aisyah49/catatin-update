# Dockerfile Catatin untuk Railway (PHP 8.3 + Laravel)
FROM php:8.3-cli

RUN apt-get update \
 && apt-get install -y --no-install-recommends git unzip libzip-dev \
 && docker-php-ext-install pdo_mysql zip opcache \
 && rm -rf /var/lib/apt/lists/*

# OPcache: kode PHP dikompilasi SEKALI lalu disimpan di memori -> permintaan jauh lebih cepat & start dingin lebih singkat.
RUN { echo 'opcache.enable=1'; echo 'opcache.enable_cli=1'; echo 'opcache.memory_consumption=128'; \
      echo 'opcache.max_accelerated_files=20000'; echo 'opcache.validate_timestamps=0'; } > /usr/local/etc/php/conf.d/opcache.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction \
 && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
 && chmod -R 777 storage bootstrap/cache

ENV PHP_CLI_SERVER_WORKERS=4
EXPOSE 8000

# Urutan start (dibuat sesingkat mungkin supaya "cold start" cepat):
#  1. catatin:setup  = siapkan database otomatis (tabel, trigger, view, kolom login/sinkron, akun bawaan). Tidak menghapus data.
#  2. optimize       = simpan cache konfigurasi/rute/tampilan agar tiap permintaan tidak membacanya ulang (bila gagal, lanjut saja).
#  3. serve          = jalankan server. Alamat /up (health check) menjawab begitu server siap.
CMD php artisan catatin:setup && (php artisan optimize || true) && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
