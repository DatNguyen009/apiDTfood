<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNCCTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('NCC', function (Blueprint $table) {
            $table->string("materials_name");
            $table->string("materials_amount");
            $table->string("materials_price")->default("0");
            $table->string("materials_unit");
            $table->string("NCC_dateCreated");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('NCC');
    }
}
