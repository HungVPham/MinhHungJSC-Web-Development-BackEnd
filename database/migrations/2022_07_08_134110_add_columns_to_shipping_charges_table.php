<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToShippingChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_charges', function (Blueprint $table) {
            $table->bigInteger('0_1000g')->after('country');
            $table->bigInteger('1001_3000g')->after('0_1000g');
            $table->bigInteger('3001_5000g')->after('1001_3000g');
            $table->bigInteger('5001_10000g')->after('3001_5000g');
            $table->bigInteger('above_10000g')->after('5001_10000g');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_charges', function (Blueprint $table) {
            //
        });
    }
}
