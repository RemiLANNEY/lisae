<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('structureContacts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->timestamps();
            $table->integer('structure_id');
            $table->integer('contacts_id');
            $table->text('fonction')->nullable();
        });
        Schema::table('structureContacts', function(Blueprint $table){
            $table->index(['structure_id', 'contacts_id']);
        });
        

        //participants étant un contact physique
        Schema::create('participantsContacts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->timestamps();
            $table->integer('contacts_id');
            $table->integer('participants_id');
            $table->text('notes');
        });
        Schema::table('participantsContacts', function(Blueprint $table){
            $table->index(['participants_id', 'contacts_id']);
        });        



        Schema::create('participantsStructure', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->timestamps();
            $table->integer('contacts_id');
            $table->integer('structure_id');
            $table->text('notes');
        });
        Schema::table('participantsStructure', function(Blueprint $table){
            $table->index(['structure_id', 'contacts_id']);
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
        Schema::dropIfExists('structureContats');
        Schema::dropIfExists('participantsContacts');
        Schema::dropIfExists('participantsStructure');
    }
}
