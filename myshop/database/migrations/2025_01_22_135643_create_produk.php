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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->unsignedBigInteger('category_id');
            $table->integer('jumlah');
            $table->string('satuan'); 
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->integer('stock')->default(0);
            $table->text('description')->nullable(); 
            $table->timestamps(); 

            // Foreign key ke tabel categories
            $table->foreign('category_id')->references('id')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
