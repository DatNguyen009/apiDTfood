<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierpricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplierprices', function (Blueprint $table) {
            $table->increments("supplierprice_id");
            $table->string("materials_name");
            $table->string("materials_amount");
            $table->string("materials_price");
            $table->string("materials_unit");
            $table->string("created_at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplierprices');
    }
}
