<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialNormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materialNorms', function (Blueprint $table) {
            $table->string("material_id");
            $table->string("material_name");
            $table->string("material_dmt");
            $table->string("material_dms");
            $table->string("material_slhh");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materialNorms');
    }
}
