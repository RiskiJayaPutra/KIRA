<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Referensi ke Varian, karena pembeli gacha/blindbox biasanya mengincar 1 jenis figur spesifik (Secret)
            $table->foreignId('product_variant_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            
            // Pengamanan Duplikasi: Satu pengguna hanya bisa mem-favoritkan 1 jenis figure spesifik sebanyak 1 kali.
            // Ini untuk menjaga kemurnian data analisis pasar (Big Data).
            $table->unique(['user_id', 'product_variant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
