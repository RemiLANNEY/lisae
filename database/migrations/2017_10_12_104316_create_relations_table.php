<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    	Schema::table('promos', function(Blueprint $table) {
    		$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
    	});
    	Schema::table('users', function(Blueprint $table) {
    		$table->foreign('promo_id')->references('id')->on('promos')->nullable();
    	});
//     	Schema::table("selectionCandidats", function (Blueprint $table){
//     		$table->foreign("id_candidats")->references("id")->on("candidats");
//     		$table->foreign("id_question")->references("id")->on("questions");
//     	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    	Schema::dropIfExists('candidats');
    }
}
