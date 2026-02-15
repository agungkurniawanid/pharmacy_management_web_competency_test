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
        Schema::create('penjualan_details', function (Blueprint $table) {
            $table->string('nota', 20)->nullable(false);
            $table->string('kode_obat', 20)->nullable(false);
            $table->integer('jumlah')->nullable(false);
                        $table->integer('harga_jual')->nullable(false);
            $table->integer('subtotal')->nullable(false);
            $table->timestamps();

            $table->foreign('nota')
                ->references('nota')
                ->on('penjualans')
                ->cascadeOnDelete();
                
            $table->foreign('kode_obat')
                ->references('kode_obat')
                ->on('obats')
                ->cascadeOnDelete();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_details');
    }
};
