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
        Schema::table('data_sarana', function (Blueprint $table) {
            $table->foreign(['id_ruangan'], 'fk_sarana_ruangan')->references(['id_ruangan'])->on('ruangan')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_sarana', function (Blueprint $table) {
            $table->dropForeign('fk_sarana_ruangan');
        });
    }
};
