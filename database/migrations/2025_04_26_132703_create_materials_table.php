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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pegawai');
            $table->unsignedBigInteger('id_kode_qr');
            $table->string('status');
            $table->timestamps();

            // Relasi ke tabel users
            $table->foreign('id_pegawai')->references('id')->on('users')->onDelete('cascade');

            // Relasi ke tabel qrcodes
            $table->foreign('id_kode_qr')->references('id')->on('qrcodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
