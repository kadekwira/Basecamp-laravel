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
        Schema::create('transaksi_sewas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_customer');
            $table->bigInteger('id_product');
            $table->bigInteger('jumlah');
            $table->double("harga_product");
            $table->double("harga_hilang")->nullable();
            $table->double("harga_telat")->nullable();
            $table->double("harga_rusak")->nullable();
            $table->date('tgl_pesanan');
            $table->date('tgl_kembali');
            $table->double('total');
            $table->string('status');
            $table->string('status_payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_sewas');
    }
};
