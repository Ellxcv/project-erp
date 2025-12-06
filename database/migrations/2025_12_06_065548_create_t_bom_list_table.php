<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_bom_list', function (Blueprint $table) {
            // ganti jadi auto-increment
            $table->bigIncrements('kode_bom_list');

            $table->unsignedBigInteger('kode_bom');
            $table->unsignedBigInteger('kode_produk');
            $table->decimal('qty', 15, 2)->default(0);
            $table->string('satuan', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_bom_list');
    }
};
