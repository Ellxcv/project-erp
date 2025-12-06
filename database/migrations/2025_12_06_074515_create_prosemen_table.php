<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prosemen', function (Blueprint $table) {
            $table->bigIncrements('id');

            // relasi ke t_bom_list.kode_bom_list (yang kita buat bigIncrements juga)
            $table->unsignedBigInteger('kode_bom_list');

            // qty_order = qty per BOM * qty MO
            $table->decimal('qty_order', 15, 2)->default(0);

            // optional: foreign key (boleh ditambahkan nanti)
            // $table->foreign('kode_bom_list')
            //       ->references('kode_bom_list')
            //       ->on('t_bom_list')
            //       ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prosemen');
    }
};
