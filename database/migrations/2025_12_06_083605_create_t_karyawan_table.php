<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_karyawan', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Nama karyawan
            $table->string('name', 150);

            // Relasi ke t_jobpos.id
            $table->unsignedBigInteger('id_job');

            // Tidak pakai timestamps, sesuai model
            // $table->timestamps(false);

            // Optional foreign key (bisa diaktifkan nanti)
            // $table->foreign('id_job')
            //       ->references('id')->on('t_jobpos')
            //       ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_karyawan');
    }
};
