<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_jobpos', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Nama posisi (misal: Admin, Operator, Manager)
            $table->string('position', 100);

            // Relasi ke t_departement.id
            $table->unsignedBigInteger('depart');

            // Tidak pakai timestamps
            // $table->timestamps(false);

            // Optional FK (bisa dinyalain nanti kalau semua tabel sudah stabil)
            // $table->foreign('depart')
            //       ->references('id')
            //       ->on('t_departement')
            //       ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_jobpos');
    }
};
