<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code' , 100)->unique();
            $table->float('price');
            $table->string('image' , 255)->nullable();
            $table->string('name' , 255);
            $table->integer('stock');
            $table->date('manufacturing_date')->nullable(); //data de fabricação
            $table->date('shelflife_date')->nullable();     //data de validade
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
        });

        Schema::table('products' , function($table){
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
        Schema::dropIfExists('products');
    }
}
