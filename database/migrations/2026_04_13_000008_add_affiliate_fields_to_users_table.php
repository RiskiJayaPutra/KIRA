<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kode unik afiliasi untuk mendeteksi asal rujukan (Referral)
            $table->string('affiliate_code')->unique()->nullable()->after('kira_points');
            
            // Dompet rupiah untuk menyimpan komisi yang siap dicairkan (Withdrawal)
            $table->decimal('affiliate_balance', 12, 2)->default(0)->after('affiliate_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['affiliate_code', 'affiliate_balance']);
        });
    }
};
