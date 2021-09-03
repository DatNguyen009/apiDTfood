<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments("product_id");
            $table->string("product_name");
            $table->string("product_slug")->unique();
            $table->string("product_price");
            $table->string("product_amount");
            $table->string("product_status");
            $table->string("product_description");
            $table->string("product_sold");
            $table->string("isDeleted")->default("0");
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
}
