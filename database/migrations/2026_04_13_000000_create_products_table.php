<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // Unique Index
            $table->string('name');
            $table->boolean('is_blindbox')->default(false); // Pembeda logic gacha
            $table->text('description')->nullable();
            $table->timestamp('release_date')->nullable(); // Untuk FOMO Countdown
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
