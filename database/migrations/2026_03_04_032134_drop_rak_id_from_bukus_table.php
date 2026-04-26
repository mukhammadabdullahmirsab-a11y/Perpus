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
        Schema::table('bukus', function (Blueprint $table) {
            // Drop foreign key constraint first if exists
            if (Schema::hasColumn('bukus', 'rak_id')) {
                $table->dropForeign(['rak_id']);
                $table->dropColumn('rak_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->foreignId('rak_id')->nullable()->constrained('raks')->nullOnDelete();
        });
    }
};
