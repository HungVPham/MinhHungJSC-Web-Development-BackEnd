<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHhoseProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hhose_product_attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('category_id');
            $table->string('diameter'); 
            // ['1/4 Inch','5/16 Inch','3/8 Inch','1/2 Inch','5/8 Inch','3/4 Inch','1 Inch','1-1/4 Inch','1-1/2 Inch','2 Inch']);
            $table->enum('hhose_spflex_embossed', ['No', 'Yes']);
            $table->enum('hhose_spflex_smoothtexture', ['No', 'Yes']);
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
        Schema::dropIfExists('hhose_product_attributes');
    }
}
