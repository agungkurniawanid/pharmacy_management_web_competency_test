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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->string('nota', 20)->primary();
            $table->dateTime('tanggal_nota')->nullable(false);
            $table->string('kode_supplier',20)->nullable(false);
            $table->decimal('diskon', 5, 2)->nullable();
            $table->timestamps();

            $table->foreign('kode_supplier')->references('kode_supplier')->on('suppliers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
