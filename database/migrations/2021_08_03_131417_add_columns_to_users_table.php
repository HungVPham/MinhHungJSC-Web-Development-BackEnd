<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->after('name');
            $table->string('address')->after('last_name');
            $table->string('city')->after('address');
            $table->string('state')->after('city');
            $table->string('pincode')->after('state');
            $table->string('mobile')->after('pincode');
            $table->tinyInteger('status')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('last_name');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('pincode');
            $table->dropColumn('status');
            $table->dropColumn('mobile');
        });
    }
}
