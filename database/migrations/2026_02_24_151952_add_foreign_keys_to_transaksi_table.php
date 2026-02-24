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
        Schema::table('transaksi', function (Blueprint $table) {
            $table->foreign(['id_bidang'], 'fk_transaksi_bidang')->references(['id_bidang'])->on('bidang_pegawai')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['id_ruangan'], 'fk_transaksi_ruangan')->references(['id_ruangan'])->on('ruangan')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['id_user'], 'fk_transaksi_user')->references(['id_user'])->on('user')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign('fk_transaksi_bidang');
            $table->dropForeign('fk_transaksi_ruangan');
            $table->dropForeign('fk_transaksi_user');
        });
    }
};
