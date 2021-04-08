<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('section_id');
            $table->string('product_name');
            $table->string('product_code');
            $table->float('product_price');
            $table->float('product_discount');
            $table->float('product_weight');
            $table->string('maxpro_voltage')->nullable();
            $table->string('maxpro_power')->nullable();
            $table->string('hhose_diameter')->nullable();
            $table->enum('hhose_embossed', ['No', 'Yes'])->nullable();
            $table->enum('hhose_smoothtexture', ['No', 'Yes'])->nullable();
            $table->string('shimge_power')->nullable();
            $table->string('shimge_maxflow')->nullable();
            $table->string('main_image');
            $table->string('image_v1');
            $table->string('image_v2');
            $table->string('image_v3');
            $table->string('product_video')->nullable();
            $table->string('product_rating');
            $table->text('product_description');
            $table->string('meta_title');
            $table->string('meta_keywords');
            $table->string('meta_description');
            $table->enum('is_featured',['No', 'Yes']);
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
        Schema::dropIfExists('products');
    }
}
