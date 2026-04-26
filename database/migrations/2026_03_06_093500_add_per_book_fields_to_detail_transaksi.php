<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->date('tanggal_pengembalian')->nullable()->after('jumlah');
            $table->date('tanggal_kembali')->nullable()->after('tanggal_pengembalian');
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam')->after('tanggal_kembali');
        });

        // Copy tanggal_pengembalian from transaksis to each detail_transaksi
        $details = DB::table('detail_transaksi')
            ->join('transaksis', 'detail_transaksi.transaksi_id', '=', 'transaksis.id')
            ->select('detail_transaksi.id', 'transaksis.tanggal_pengembalian', 'transaksis.tanggal_kembali', 'transaksis.status')
            ->get();

        foreach ($details as $detail) {
            $updateData = [
                'tanggal_pengembalian' => $detail->tanggal_pengembalian,
            ];

            // If transaksi is 'dikembalikan', mark all details as dikembalikan too
            if ($detail->status === 'dikembalikan') {
                $updateData['status'] = 'dikembalikan';
                $updateData['tanggal_kembali'] = $detail->tanggal_kembali;
            }

            DB::table('detail_transaksi')->where('id', $detail->id)->update($updateData);
        }
    }

    public function down(): void
    {
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->dropColumn(['tanggal_pengembalian', 'tanggal_kembali', 'status']);
        });
    }
};
