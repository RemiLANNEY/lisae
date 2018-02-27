<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('selections', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_candidats');
            $table->integer('users_id');
            $table->tinyInteger('pre_admin', 2)->nullable();
            $table->tinyInteger('pre_motiv', 2)->nullable();
            $table->tinyInteger('pre_techn', 2)->nullable();
            $table->tinyInteger('admin', 2)->nullable();
            $table->tinyInteger('motiv', 2)->nullable();
            $table->tinyInteger('techn', 2)->nullable();
        });

        /*
        
CREATE TABLE `selections` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_candidats` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `pre_admin` int(2) NOT NULL DEFAULT '0',
  `pre_motiv` int(2) NOT NULL DEFAULT '0',
  `pre_techn` int(2) NOT NULL DEFAULT '0',
  `admin` int(2) NOT NULL DEFAULT '0',
  `motiv` int(2) NOT NULL DEFAULT '0',
  `techn` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
