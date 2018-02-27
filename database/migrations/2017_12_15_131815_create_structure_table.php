<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStructureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('structure', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->text('nom');
            $table->text('adresse1')->nullable();
            $table->text('adresse2')->nullable();
            $table->text('cp')->nullable();
            $table->text('ville')->nullable();
            $table->text('tel')->nullable();
            $table->text('email')->nullable();
            $table->text('site')->nullable();
            $table->text('typeStructure')->nullable();
            $table->text('notes')->nullable();
            $table->text('logo')->nullable();
            $table->integer("users_id")->nullable();
            
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
        Schema::dropIfExists('structure');
    }
}
