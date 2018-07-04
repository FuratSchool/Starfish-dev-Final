<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSpecialistDiverseCouple
 */
class CreateSpecialistDiverseCouple extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialists_diverses', function (Blueprint $table) {
            $table->integer('specialist_id')->unsigned();
            $table->integer('diverse_id')->unsigned();
            $table->primary(['specialist_id', 'diverse_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialists_diverses');
    }
}
