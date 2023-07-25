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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number',255)->nullable(false);
            $table->unsignedBigInteger('order_id')->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->float('gross_import')->nullable(false);
            $table->string('payment_method',255)->nullable(false);
            $table->string('payment_code_1',255)->nullable(false);
            $table->string('payment_code_2',255)->nullable(false);
            $table->string('pdf_url',255)->nullable(false);
            $table->enum('status',['pending','paid','cancelled'])->default('pending');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('invoices');
    }
};
