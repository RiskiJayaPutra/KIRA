<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('affiliate_id')->nullable(); // Tautan KOL opsional
            $table->text('shipping_address');
            $table->enum('status', ['PENDING', 'PAID', 'SHIPPED', 'COMPLETED', 'DISPUTED'])->default('PENDING');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->decimal('total_price', 12, 2);
            $table->string('awb_resi')->nullable(); // Nomor Resi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
