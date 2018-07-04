<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserAdminAccessPivot
 */
class CreateUserAdminAccessPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_accesses', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('access_id')->unsigned();
            $table->primary(['user_id', 'access_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_accesses');
    }
}
