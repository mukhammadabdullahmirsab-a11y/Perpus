<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create detail_transaksi table
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksis')->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('bukus');
            $table->integer('jumlah')->default(1);
            $table->enum('kondisi_buku', ['baik', 'rusak', 'hilang'])->default('baik');
            $table->decimal('denda_kerusakan', 10, 2)->default(0);
            $table->timestamps();
        });

        // 2. Migrate existing data from transaksis to detail_transaksi
        $transaksis = DB::table('transaksis')->whereNotNull('buku_id')->get();
        foreach ($transaksis as $trx) {
            DB::table('detail_transaksi')->insert([
                'transaksi_id' => $trx->id,
                'buku_id' => $trx->buku_id,
                'jumlah' => 1,
                'kondisi_buku' => $trx->kondisi_buku ?? 'baik',
                'denda_kerusakan' => $trx->denda_kerusakan ?? 0,
                'created_at' => $trx->created_at,
                'updated_at' => $trx->updated_at,
            ]);
        }

        // 3. Drop old columns from transaksis
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['buku_id']);
            $table->dropColumn(['buku_id', 'kondisi_buku', 'denda_kerusakan']);
        });
    }

    public function down(): void
    {
        // Re-add columns to transaksis
        Schema::table('transaksis', function (Blueprint $table) {
            $table->foreignId('buku_id')->nullable()->constrained('bukus');
            $table->enum('kondisi_buku', ['baik', 'rusak', 'hilang'])->default('baik');
            $table->decimal('denda_kerusakan', 10, 2)->default(0);
        });

        // Migrate data back
        $details = DB::table('detail_transaksi')->get();
        foreach ($details as $detail) {
            DB::table('transaksis')->where('id', $detail->transaksi_id)->update([
                'buku_id' => $detail->buku_id,
                'kondisi_buku' => $detail->kondisi_buku,
                'denda_kerusakan' => $detail->denda_kerusakan,
            ]);
        }

        Schema::dropIfExists('detail_transaksi');
    }
};
