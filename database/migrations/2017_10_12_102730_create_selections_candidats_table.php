<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectionsCandidatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    	Schema::create('selectionCandidats', function (Blueprint $table) {
    		$table->engine = 'InnoDB';
    		$table->increments('id');
    		$table->timestamps();
    		$table->integer('id_candidats');
    		$table->integer('id_question');
    		$table->text('reponse')->nullable();
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
    	Schema::dropIfExists('selectionCandidats');
    }
}
