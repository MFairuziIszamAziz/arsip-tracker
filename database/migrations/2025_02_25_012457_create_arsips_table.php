<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('arsips', function (Blueprint $table) {
        $table->id();
        $table->string('kode_barcode')->unique();
        $table->string('nama_arsip');
        $table->string('lokasi');
        $table->text('deskripsi')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};
