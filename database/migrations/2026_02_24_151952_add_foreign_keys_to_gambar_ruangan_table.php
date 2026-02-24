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
        Schema::table('gambar_ruangan', function (Blueprint $table) {
            $table->foreign(['id_ruangan'], 'gambar_ruangan_ibfk_1')->references(['id_ruangan'])->on('ruangan')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gambar_ruangan', function (Blueprint $table) {
            $table->dropForeign('gambar_ruangan_ibfk_1');
        });
    }
};
