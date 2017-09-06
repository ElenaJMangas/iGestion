<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tasks extends Migration
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
            $table->integer('user_id')->required()->unsigned()->comment("User owner");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title')->required()->comment("Task Title");
            $table->text('description')->required()->comment("Task Description");
            $table->integer('priority_id')->nullable()->unsigned()->default(1)->comment("Task priority");
            $table->foreign('priority_id')->references('id')->on('priorities')->onDelete('cascade');
            $table->integer('status_id')->required()->unsigned()->comment("Task status");
            $table->foreign('status_id')->references('id')->on('tasks_status')->onDelete('cascade');
            $table->integer('done_user_id')->nullable()->comment("User that done the task");
            $table->integer('project_id')->nullable()->unsigned()->comment("Project owner");
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->timestamp('target_end_date')->nullable()->comment("Task target end date");
            $table->timestamp('actual_end_date')->nullable()->comment("Task actual end date");
            $table->timestamps();
            $table->softDeletes();
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
    }
}
