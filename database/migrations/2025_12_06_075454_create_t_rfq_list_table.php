<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_rfq_list', function (Blueprint $table) {
            $table->bigIncrements('id_rfq_list');

            // Header RFQ
            $table->unsignedBigInteger('id_rfq');

            // Produk / bahan
            $table->unsignedBigInteger('kode_produk');

            // Qty dan satuan
            $table->decimal('qty', 15, 2)->default(0);
            $table->string('satuan', 50)->nullable();

            // Optional: foreign key (boleh ditambah nanti kalau semua sudah stabil)
            // $table->foreign('id_rfq')->references('id_rfq')->on('t_rfq')->onDelete('cascade');
            // $table->foreign('kode_produk')->references('id')->on('t_produk')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_rfq_list');
    }
};
