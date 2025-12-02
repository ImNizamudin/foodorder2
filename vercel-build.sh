#!/bin/bash

# 1. Instal Composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 2. Jalankan Composer install
composer install --no-dev --prefer-dist

# 3. Jalankan Migrasi Database (Wajib untuk produksi)
php artisan migrate --force

# 4. Jalankan Frontend Build
npm run build

# Jika Anda tidak menggunakan npm (tanpa frontend), hapus baris 'npm run build'
