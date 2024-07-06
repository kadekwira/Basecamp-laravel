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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("nama_product");
            $table->double("harga_product");
            $table->double("harga_hilang")->nullable();
            $table->double("harga_telat")->nullable();
            $table->double("harga_rusak")->nullable();
            $table->string("status");
            $table->string("image");
            $table->bigInteger("stock");
            $table->enum("type",['jual','sewa']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
