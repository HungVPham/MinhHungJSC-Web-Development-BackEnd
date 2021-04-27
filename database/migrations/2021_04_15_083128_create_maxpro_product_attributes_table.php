<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaxproProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maxpro_product_attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('section_id');
            $table->string('voltage')->nullable();
            $table->string('power')->nullable();
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
        Schema::dropIfExists('maxpro_product_attributes');
    }
}
