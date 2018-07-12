<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSpecialistsTable
 */
class CreateSpecialistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('adverb');
            $table->string('sur_name');
            $table->string('gender');
            $table->string('occupation');
            $table->double('map_lat', 10, 6);
            $table->double('map_lng', 10, 6);
            $table->string('address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('region');
            $table->string('country');
            $table->boolean('is_anonymous')->default(0);
            $table->timestamps();

            // Non-anonymous fields
            $table->string('url_name')->unique()->nullable();
            $table->string('profile_image')->nullable();
            $table->string('company')->nullable();
            $table->text('story')->nullable();
            $table->string('mission')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('url')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialists');
    }
}
