<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    	Schema::create('promos', function(Blueprint $table) {
    		$table->increments('id');
    		$table->timestamps();
    		$table->string('titre');
    		$table->string('ville');
    		$table->string('pays')->default('Fr');
    		$table->date('dateDebutPromo');
    		$table->date('dateFinPromo');
    		$table->text('description');
    		$table->integer('user_id')->unsigned();
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
    	Schema::drop('promos');
    }
}
