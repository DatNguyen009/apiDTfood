<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments("order_id");
            $table->string("customers_id");
            $table->foreign("customers_id")->references("customers_email")->on("customers")->onDeleted("cascade");
            $table->string("order_status");
            $table->string("order_dateCreated");
            $table->string("order_dateReceived");
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
}
