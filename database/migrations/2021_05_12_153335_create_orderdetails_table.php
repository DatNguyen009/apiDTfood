<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderdetails', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->foreign("order_id")->references("order_id")->on("orders")->onDeleted("cascade");
            $table->string("product_id");
            $table->foreign("product_id")->references("product_slug")->on("products");
            $table->string("orderDetail_amount");
            $table->string("orderDetail_price");
            $table->string("orderDetail_totalMoney");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderdetails');
    }
}
