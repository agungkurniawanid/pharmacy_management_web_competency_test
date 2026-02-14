<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->string('kode_pelanggan', 20)->primary();
            $table->string('nama_pelanggan', 50)->nullable(false);
            $table->text('alamat', 100)->nullable();
            $table->string('kota',50)->nullable();
            $table->string('telpon',13)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
