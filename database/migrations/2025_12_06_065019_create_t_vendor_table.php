<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_vendor', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('nama_vendor', 191);
            $table->string('telpon', 50);
            $table->text('alamat');

            // 1 = Vendor, 2 = ???, 3 = User (dipakai di beberapa controller)
            $table->tinyInteger('status')->default(1);

            // Perusahaan induk / company reference
            $table->string('company', 191)->nullable();

            // Tidak ada timestamps karena di model: public $timestamps = false;
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_vendor');
    }
};
