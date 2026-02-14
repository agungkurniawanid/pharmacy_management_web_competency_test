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
        Schema::create('pembelian_details', function (Blueprint $table) {
            $table->string('nota', 20)->nullable(false);
            $table->string('kode_obat',20)->nullable(false);
            $table->integer('jumlah')->nullable(false);
            $table->timestamps();

            $table->foreign('nota')->references('nota')->on('pembelians')->cascadeOnDelete();
            $table->foreign('kode_obat')->references('kode_obat')->on('obats')->cascadeOnDelete();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_details');
    }
};
