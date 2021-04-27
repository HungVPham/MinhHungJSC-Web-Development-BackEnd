<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShimgeProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shimge_product_attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('category_id');
            $table->integer('voltage');
            $table->bigInteger('power');
            $table->integer('maxflow');
            $table->integer('verical');
            $table->integer('indiameter');
            $table->integer('outdiameter');
            $table->bigInteger('price');
            $table->bigInteger('stock');
            $table->string('sku');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('shimge_product_attributes');
    }
}
