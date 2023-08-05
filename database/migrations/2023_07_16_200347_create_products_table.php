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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->nullable(false);
            $table->unsignedBigInteger('category_id')->nullable(false);
            $table->string('description',255)->nullable(false);
            $table->string('details',1500)->nullable(false);
            $table->float('price')->nullable(false);
            $table->json('tags');
            $table->string('label',255)->nullable(true);
            $table->boolean('is_new')->nullable();
            $table->boolean('is_unity')->nullable();
            $table->integer('stock')->nullable(true);
            $table->string('image_url_1',1500)->nullable(false);
            $table->string('image_url_2',1500)->nullable(true);
            $table->string('image_url_3',1500)->nullable(true);
            $table->string('image_url_4',1500)->nullable(true);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
};
