<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->string("product_id");
            $table->foreign("product_id")->references("product_slug")->on("products")->onDeleted("cascade");
            $table->string("customers_id");
            $table->foreign("customers_id")->references("customers_email")->on("customers")->onDeleted("cascade");
            $table->string("review_content");
            $table->string("review_dateCreated");
            $table->string("isDeleted")->default("0");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
