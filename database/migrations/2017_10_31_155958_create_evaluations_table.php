<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        
    	Schema::create('evaluations', function (Blueprint $table) {
    		$table->engine = 'InnoDB';
    		$table->increments('id');
    		$table->timestamps();
    		$table->integer('id_etudiant')->unsigned();
    		$table->boolean("final")->default(false);
    		$table->text("text")->nullable();
    		
    	});
    	
    		Schema::table('evaluations', function(Blueprint $table) {
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
    	Schema::dropIfExists('evaluations');
    }
}
