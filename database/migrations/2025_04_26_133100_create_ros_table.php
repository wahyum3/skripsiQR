<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_qrcode'); // FK ke qrcodes.id
            $table->string('nomor_ro');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('id_qrcode')->references('id')->on('qrcodes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ros');
    }
};

