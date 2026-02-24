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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->integer('id_peminjaman', true);
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            $table->string('acara', 100);
            $table->string('catatan', 100);
            $table->string('foto_kegiatan')->nullable();
            $table->enum('status_peminjaman', ['Menunggu', 'Disetujui', 'Ditolak', 'Dibatalkan']);
            $table->integer('jumlah_peserta');
            $table->integer('id_bidang')->index('id_bidang');
            $table->integer('id_ruangan')->index('id_ruangan');
            $table->integer('id_user')->nullable()->index('id_user');
            $table->string('no_wa', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
