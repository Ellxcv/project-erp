<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_produk', function (Blueprint $table) {
            $table->bigIncrements('id'); // primary key

            $table->string('nama_produk', 191);
            $table->string('id_reference', 100)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar', 255)->nullable();

            $table->decimal('qty', 15, 2)->default(0);
            $table->decimal('harga', 15, 2)->default(0);

            // 1 = aktif, 0 = nonaktif
            $table->tinyInteger('status')->default(1);

            // sesuai model: $timestamps = false → TIDAK pakai created_at/updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_produk');
    }
};
