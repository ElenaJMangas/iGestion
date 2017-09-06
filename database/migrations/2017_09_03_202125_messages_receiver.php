<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MessagesReceiver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_receiver', function (Blueprint $table) {
            $table->integer('message_id')->required()->unsigned()->comment('Message Id');
            $table->integer('user_id')->required()->unsigned()->comment('User id');
            $table->tinyInteger('read')->nullable()->unsigned()->default(0)->comment("Read 0 No | 1 Yes");
            $table->timestamps();
            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->primary(['user_id', 'message_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages_receiver');
    }
}
