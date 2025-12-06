<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_bom', function (Blueprint $table) {
            $table->bigIncrements('id');

            // BM001, BM002, dst
            $table->string('kode_bom', 100)->unique();

            // relasi ke t_produk.id
            $table->unsignedBigInteger('kode_produk');

            // di controller diset pakai date("Y/m/d")
            $table->date('tanggal');

            $table->decimal('total_harga', 15, 2)->default(0);

            // kalau mau, boleh tambahkan FK (opsional)
            // $table->foreign('kode_produk')->references('id')->on('t_produk');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_bom');
    }
};
