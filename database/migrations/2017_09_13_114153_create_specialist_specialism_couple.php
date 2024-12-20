<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSpecialistSpecialismCouple
 */
class CreateSpecialistSpecialismCouple extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialists_specialisms', function (Blueprint $table) {
            $table->integer('specialist_id')->unsigned();
            $table->integer('specialism_id')->unsigned();
            $table->integer('prio')->unsigned();
            $table->primary(['specialist_id', 'specialism_id']);
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialists_specialisms');
    }
}
