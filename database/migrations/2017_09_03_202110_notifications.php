<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('notification')->required()->comment("Notification description");
            $table->string('action')->required()->comment("Notification url");
            $table->tinyInteger('type')->nullable()->unsigned()->default(0)->comment("Notification Type 0 General | 1 Projects | 2 Tasks | 3 Events | 4 Messages");
            $table->integer('source_id')->nullable()->unsigned()->comment("Notification source");
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
        Schema::dropIfExists('notifications');
    }
}
