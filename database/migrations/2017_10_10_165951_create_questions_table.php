<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    	Schema::create("questions", function(Blueprint $table){
    		//profil
    		$table->increments('id');
    		$table->string('code');
    		$table->text('colonne');
    		$table->text('question');
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
        //
    	Schema::drop("questions");
    }
}
