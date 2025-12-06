<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_sq_list', function (Blueprint $table) {
            // PK
            $table->bigIncrements('id_sq_list');

            // Relasi ke t_sq.id (bukan ke id_sq string)
            $table->unsignedBigInteger('id_sq');

            // Produk
            $table->unsignedBigInteger('kode_produk');

            // Qty & satuan
            $table->decimal('qty', 15, 2)->default(0);
            $table->string('satuan', 50)->nullable();

            // Subtotal per baris
            $table->decimal('total', 15, 2)->default(0);

            // Optional foreign key (bisa diaktifkan nanti)
            // $table->foreign('id_sq')->references('id')->on('t_sq')->onDelete('cascade');
            // $table->foreign('kode_produk')->references('id')->on('t_produk')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_sq_list');
    }
};
