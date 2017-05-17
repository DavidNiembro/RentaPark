<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTParkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_park', function (Blueprint $table) {
            $table->increments('idPark');
            $table->string('parNumber');
            $table->string('parAddress');
            $table->string('parPostCode');
            $table->string('parCity');
            $table->string('parPrice');
            $table->string('parDelete')->nullable();
            $table->string('parLatitude')->nullable();
            $table->string('parLongitude')->nullable();
            $table->boolean('parCouvert');
            $table->integer('fkUser');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_park');
    }
}
