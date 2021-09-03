<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatetoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catetory', function (Blueprint $table) {
            $table->string("product_id");
            $table->foreign("product_id")->references("product_slug")->on("products")->onDeleted("cascade");
            $table->string("category_name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catetory');
    }
}
