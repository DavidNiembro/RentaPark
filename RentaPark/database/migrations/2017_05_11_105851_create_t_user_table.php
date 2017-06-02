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
            $table->string('usePictureProfil');
            $table->string('email');
            $table->string('useName');
            $table->string('useFirstName');
            $table->string('useCity');
            $table->string('useLand');
            $table->boolean('confirmed')->default(false);
            $table->string('confirmation_code')->nullable();
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
