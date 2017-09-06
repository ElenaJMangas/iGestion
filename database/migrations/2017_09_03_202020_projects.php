<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Projects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->required()->unsigned()->comment("User owner");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title')->required()->unique()->comment("Project Title");
            $table->text('description')->required()->comment("Project Description");
            $table->integer('priority_id')->nullable()->unsigned()->default(1)->comment("Project priority");
            $table->tinyInteger('status_id')->nullable()->unsigned()->default(0)->comment("Project status 0 In progress | 1 Finished");
            $table->foreign('priority_id')->references('id')->on('priorities')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
