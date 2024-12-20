<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSpecialistImageCouple
 */
class CreateSpecialistImageCouple extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialists_images', function (Blueprint $table) {
            $table->integer('specialist_id')->unsigned();
            $table->integer('image_id')->unsigned();
            $table->primary(['specialist_id', 'image_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialists_images');
    }
}
