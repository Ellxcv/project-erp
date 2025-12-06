<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        Schema::create('t_sq', function (Blueprint $table) {
            // PK auto increment, dipakai di where('t_sq.id', ...)
            $table->bigIncrements('id');

            // Kode SQ (SQ001, SQ002, ...)
            $table->string('id_sq', 100)->unique();

            // Relasi ke t_vendor.id
            $table->unsignedBigInteger('id_pelanggan');

            // Tanggal transaksi
            $table->date('tanggal_transaksi');

            // Status flow SQ (0 = draft, dst)
            $table->tinyInteger('status')->default(0);

            // Total harga SQ
            $table->decimal('total_harga', 15, 2)->default(0);

            // Metode pembayaran: 0 = belum, 1 = cash, 2 = transfer
            $table->tinyInteger('metode_pembayaran')->default(0);

            // Optional foreign key (bisa diaktifkan nanti kalau semua tabel sudah aman)
            // $table->foreign('id_pelanggan')
            //       ->references('id')->on('t_vendor')
            //       ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_sq');
    }
};
