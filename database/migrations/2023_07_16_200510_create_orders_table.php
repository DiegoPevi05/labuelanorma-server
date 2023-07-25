<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number',60)->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status',['pending','processing','completed','declined','cancelled'])->default('pending');
            $table->unsignedBigInteger('discount_code_id')->nullable(true);
            $table->foreign('discount_code_id')->references('id')->on('discount_codes')->onDelete('cascade');
            $table->float('gross_import')->nullable(false);
            $table->float('discount_amount')->nullable(false);
            $table->float('net_import')->nullable(false);
            $table->boolean('calculated_amount')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
