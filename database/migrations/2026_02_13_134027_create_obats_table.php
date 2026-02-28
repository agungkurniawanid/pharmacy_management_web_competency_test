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
        Schema::create('obats', function (Blueprint $table) {
            $table->string('kode_obat', 20)->primary();
            $table->string('nama_obat', 50)->nullable(false);
            $table->string('jenis',50)->nullable(false);
            $table->string('satuan')->nullable(false);
            $table->integer('harga_beli')->nullable(false);
            $table->integer('harga_jual')->nullable(false);
            $table->integer('stok')->nullable(false);
            $table->string('kode_supplier', 20)->nullable(false);

            $table->date('tgl_kadaluarsa')->nullable(); 
            $table->enum('status', ['Aktif', 'Nonaktif', 'Ditarik'])->default('Aktif');
            $table->timestamps();

            $table->foreign('kode_supplier')
            ->references('kode_supplier')
            ->on('suppliers')
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
