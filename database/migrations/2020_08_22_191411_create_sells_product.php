<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellsProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sells_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->float('discount');
            $table->unsignedBigInteger('tenant_id');
            $table->timestamps();
        });

        Schema::table('sells_products' , function($table){
            $table->foreign('sells_id')->references('id')->on('sells')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sells_products');
    }
}
