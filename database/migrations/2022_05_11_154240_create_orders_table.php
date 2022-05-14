<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('address');
            $table->string('ward');
            $table->string('district');
            $table->string('province');
            $table->string('state');
            $table->string('country');
            $table->string('mobile');
            $table->string('email');
            $table->BigInteger('shipping_charges');
            $table->string('coupon_code');
            $table->BigInteger('coupon_amount');
            $table->string('order_status');
            $table->string('payment_method');
            $table->string('payment_gateway');
            $table->BigInteger('grand_total');
            $table->string('company_name');
            $table->text('note');

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
        Schema::dropIfExists('orders');
    }
}
