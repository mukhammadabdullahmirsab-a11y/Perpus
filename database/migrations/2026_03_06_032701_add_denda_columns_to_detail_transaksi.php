<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->decimal('denda_keterlambatan', 10, 2)->default(0)->after('denda_kerusakan');
            $table->string('status_denda', 20)->default('bebas_denda')->after('denda_keterlambatan');
            // enum values: 'bebas_denda', 'belum_lunas', 'lunas'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->dropColumn(['denda_keterlambatan', 'status_denda']);
        });
    }
};
