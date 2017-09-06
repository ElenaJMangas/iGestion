<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->required()->comment("User Name");
            $table->string('surname')->required()->comment("User Surname");
            $table->string('username')->required()->unique()->comment("Username");
            $table->string('email')->required()->unique()->comment("User Email");
            $table->string('password')->required()->comment("User Password");
            $table->string('avatar')->nullable()->default('default.jpg');
            $table->integer('role_id')->required()->unsigned()->comment("User Role");
            $table->tinyInteger('enable')->nullable()->unsigned()->default(1)->comment("Set user disable/enable (0/1)");
            $table->rememberToken()->comment("User token to remember");
            $table->dateTime('last_login')->nullable()->comment("Date of last login");
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
