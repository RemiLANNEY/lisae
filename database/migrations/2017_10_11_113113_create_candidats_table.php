<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidats', function (Blueprint $table) {
        	$table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->string('Nom')->nullable();
            $table->string('Prenom')->nullable();
            $table->string('Sexe')->nullable();
            $table->date('Date_de_naissance')->nullable();
            $table->integer('Age')->nullable();
            $table->string('Nationalite')->nullable();
            $table->string('Adresse')->nullable();
            $table->string('CP')->nullable();
            $table->string('Ville')->nullable();
            $table->string('QPV')->nullable();
            $table->string('Email')->nullable();
            $table->string('Telephone')->nullable();
            $table->string('Statut')->nullable();
            $table->string('Num_pole_emploi')->nullable();
            $table->string('Antenne_pole_emploi')->nullable();
            $table->string('Num_secu')->nullable();
            //selection
            $table->text("Commentaires")->nullable();
            //liste promo
            $table->string("liste")->default("attente");
            $table->integer('promo_id');
            //eval
            /*$table->text("eval1")->nullable();
            $table->text("eval2")->nullable();
            $table->text("eval3")->nullable();
            $table->text("evalFinal")->nullable();
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidats');
        Schema::dropIfExists('evaluations');
    }
}
