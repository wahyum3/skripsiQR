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
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->id();
            $table->text('kode_qr');
            $table->string('jenis_material');
            $table->integer('quantity_in')->nullable();
            $table->integer('quantity_out')->nullable();
            $table->string('status')->default('QR Aktif');
            $table->timestamp('status_at')->nullable(); // Ini bisa menyimpan waktu aktivasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qrcodes');
    }
};
