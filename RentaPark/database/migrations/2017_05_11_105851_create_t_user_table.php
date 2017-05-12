<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_user', function (Blueprint $table) {
            $table->increments('idUser');
            $table->string('useUsername', 30)->unique();
            $table->string('password');
            $table->string('usePictureProfil')->nullable();
            $table->string('useMail')->nullable();
            $table->string('useName')->nullable();
            $table->string('useFirstName')->nullable();
            $table->string('useCity')->nullable();
            $table->string('useLand')->nullable();
            $table->string('useToken')->nullable();
            $table->boolean('useVerified')->nullable();
            $table->boolean('useDelete')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('t_user');
    }
}
