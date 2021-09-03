<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->string("product_id");
            $table->foreign("product_id")->references("product_slug")->on("products")->onDeleted("cascade");
            $table->string("materials_name");
            $table->string("materials_amount");
            $table->string("materials_unit");
            $table->string("materials_image")->default("khoong co url");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
