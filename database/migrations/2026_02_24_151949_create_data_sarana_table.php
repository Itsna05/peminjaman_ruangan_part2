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
        Schema::create('data_sarana', function (Blueprint $table) {
            $table->integer('id_sarana', true);
            $table->string('nama_sarana', 100);
            $table->enum('jenis_sarana', ['elektronik', 'non-elektronik']);
            $table->integer('jumlah');
            $table->integer('id_ruangan')->index('id_ruangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_sarana');
    }
};
