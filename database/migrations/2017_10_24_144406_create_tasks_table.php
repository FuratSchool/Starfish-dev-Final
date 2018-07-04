<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTasksTable
 */
class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->string('type');
            $table->string('status');
            $table->string('assigner_id');
            $table->date('deadline')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('taskables', function (Blueprint $table) {
            $table->integer('task_id');
            $table->integer('taskable_id');
            $table->string('taskable_type');
            $table->primary(['task_id', 'taskable_id', 'taskable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('taskables');
    }
}
