<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->string('nota', 20)->primary();
            $table->dateTime('tanggal_nota')->nullable(false);
            $table->string('kode_pelanggan', 20)->nullable(false);
            $table->decimal('diskon', 5, 2)->nullable(false);
            $table->integer('total_harga')->nullable(false);
            $table->integer('grand_total')->nullable(false);
            $table->timestamps();

            $table->foreign('kode_pelanggan')
            ->references('kode_pelanggan')
            ->on('pelanggans')
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
