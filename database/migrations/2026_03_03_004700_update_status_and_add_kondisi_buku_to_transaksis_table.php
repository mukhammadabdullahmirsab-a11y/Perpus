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
        // Karena mengubah ENUM di MySQL lewat blueprint string agak tricky,
        // kita akan menggunakan statement DB::statement
        
        // 1. Ubah enum status untuk menambah 'menunggu' dan 'ditolak'
        DB::statement("ALTER TABLE transaksis MODIFY COLUMN status ENUM('menunggu', 'dipinjam', 'dikembalikan', 'ditolak') DEFAULT 'menunggu'");
        
        Schema::table('transaksis', function (Blueprint $table) {
            // 2. Tambah kolom kondisi_buku dan denda_kerusakan
            $table->enum('kondisi_buku', ['baik', 'rusak', 'hilang'])->default('baik')->after('status');
            $table->integer('denda_kerusakan')->default(0)->after('kondisi_buku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['kondisi_buku', 'denda_kerusakan']);
        });
        
        // Mengembalikan ENUM status ke semula (hati-hati jika ada data 'menunggu' yang tersisa)
        DB::statement("ALTER TABLE transaksis MODIFY COLUMN status ENUM('dipinjam', 'dikembalikan') DEFAULT 'dipinjam'");
    }
};
