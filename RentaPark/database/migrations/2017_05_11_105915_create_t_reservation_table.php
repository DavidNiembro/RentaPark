<?php
/**
 * ETML
 * Auteur: David Niembro
 * Date:
 * Description: Fichier de création et suppression de la table dans la base de données
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_reservation', function (Blueprint $table) {
            $table->integer('fkUser');
            $table->integer('fkPark');
            $table->dateTime('resStartingDate');
            $table->dateTime('resFinishDate');
            $table->string('resDelete');
            $table->string('resStatus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_reservation');
    }
}
