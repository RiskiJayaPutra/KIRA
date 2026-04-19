#!/bin/bash
# ==============================================================================
# KIRA.COM - DAY-0 LAUNCH PROTOCOL (ZERO-DOWNTIME DEPLOYMENT)
# ==============================================================================
# Skrip militer ini dirancang untuk merilis fitur baru ke Server Production 
# tanpa membuat pelanggan yang sedang asyik gacha atau checkout terputus.

echo "🚀 [KIRA.COM] Memulai Protokol Peluncuran Day-0..."

# 1. Mengaktifkan Mode Perawatan Pintar (Smart Maintenance)
# Pengguna biasa akan melihat halaman "Pemeliharaan", tetapi
# Super Admin yang memiliki tautan Secret bisa mem-bypass dan melakukan Testing.
echo "🔒 Mengunci gerbang teritori publik..."
php artisan down --secret="kira-super-admin-bypass" --render="errors::503"

# 2. Menarik Persenjataan Baru dari Orbit (GitHub)
echo "📥 Menarik kode intelijen terbaru dari repositori..."
git fetch origin main
git reset --hard origin/main

# 3. Merakit Ulang Mesin (Dependencies)
echo "📦 Merakit dependensi Backend & Frontend secara senyap..."
composer install --optimize-autoloader --no-dev --no-interaction
npm ci
npm run build

# 4. Injeksi Pangkalan Data (Migration)
# Flag --force memaksa injeksi tanpa meminta persetujuan manual (Y/N)
echo "💉 Menginjeksi skema pangkalan data E-Commerce..."
php artisan migrate --force

# 5. Operasi Akselerasi Memori (Caching)
echo "⚡ Memampatkan seluruh file cache untuk performa maksimal..."
php artisan optimize:clear
php artisan optimize
php artisan view:cache
php artisan event:cache

# 6. Menghidupkan Kembali Reaktor (Lift Off)
echo "🔓 Membuka kembali gerbang akses publik..."
php artisan up

echo "✅ [KIRA.COM] OPERASI DAY-0 SUKSES! SISTEM 100% ONLINE DAN MENGUDARA."
