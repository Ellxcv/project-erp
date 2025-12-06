<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_mo', function (Blueprint $table) {
            $table->bigIncrements('id');

            // MO001, MO002, dst
            $table->string('kode_mo', 100)->unique();

            // relasi ke t_bom.id
            $table->unsignedBigInteger('kode_bom');

            // jumlah produksi
            $table->decimal('qty', 15, 2)->default(0);

            // status proses: 1 = draft, dst (sesuai logika controller)
            $table->tinyInteger('status')->default(0);

            // optional foreign key (boleh ditambah nanti kalau semua stabil)
            // $table->foreign('kode_bom')->references('id')->on('t_bom')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_mo');
    }
};
