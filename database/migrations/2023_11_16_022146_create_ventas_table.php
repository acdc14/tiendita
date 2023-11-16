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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            // $table->unsignedBigInteger('product');
            // $table->unsignedBigInteger('user');
            $table->integer('quantiy');
            $table->double('total');
            $table->timestamps();
            // $table->foreignId('product')->references('id')->on('products');
            // $table->foreignId('user')->references('id')->on('users');
            $table->foreignId('product')->constrained('products');
            $table->foreignId('user')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
