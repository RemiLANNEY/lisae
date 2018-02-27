<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    	Schema::create('absences', function (Blueprint $table) {
    		$table->engine = 'InnoDB';
    		$table->increments('id');
    		$table->timestamps();
    		$table->integer('id_etudiant')->unsigned();
    		$table->date("date");
    		$table->string("motif")->nullable();
    		$table->string("justif")->nullable();
    		
    	});
    		
    	Schema::table('absences', function(Blueprint $table) {
    		$table->foreign("id_etudiant")->references('id')->on('candidats')->onDelete('restrict')->onUpdate('restrict');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    	Schema::dropIfExists('absences');
    }
}
