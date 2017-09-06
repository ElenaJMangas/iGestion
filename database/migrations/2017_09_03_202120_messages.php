<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Messages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->required()->unsigned()->comment('From User id');
            $table->string('subject')->comment("Subject");
            $table->text('message')->comment("Message");
            $table->tinyInteger('status')->nullable()->unsigned()->default(0)->comment("Message Status 0 Draft | 1 Sent | 2 Deleted");
            $table->timestamp('date_sent')->nullable()->comment("Date sent");
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
