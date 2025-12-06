<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_rfq', function (Blueprint $table) {
            // PK, auto increment
            $table->bigIncrements('id_rfq');

            // relasi ke t_vendor.id
            $table->unsignedBigInteger('id_vendor');

            // tanggal RFQ
            $table->date('tanggal');

            // status flow: 0 = draft, dst (sesuai logika controller)
            $table->tinyInteger('status')->default(0);

            // total harga RFQ
            $table->decimal('total_harga', 15, 2)->default(0);

            // metode pembayaran / flag pembayaran
            $table->string('pembayaran', 50)->default('0');

            // optional: foreign key (bisa nyusul setelah semua beres)
            // $table->foreign('id_vendor')->references('id')->on('t_vendor')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_rfq');
    }
};
