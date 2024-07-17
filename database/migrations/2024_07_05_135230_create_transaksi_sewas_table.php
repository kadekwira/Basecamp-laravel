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
            $table->bigInteger('id_customer')->unsigned();
            $table->bigInteger('id_order')->unsigned();
            $table->double("total_sewa_awal");
            $table->double("harga_hilang")->nullable();
            $table->double("harga_telat")->nullable();
            $table->double("harga_rusak")->nullable();
            $table->date('tgl_pesanan');
            $table->date('tgl_kembali');
            $table->double('total');
            $table->string('status');
            $table->string('status_payment');
            $table->timestamps();
            $table->foreign('id_customer')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_order')->references('id')->on('orders')->onDelete('cascade');
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
