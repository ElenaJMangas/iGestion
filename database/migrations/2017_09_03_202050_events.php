<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Events extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->required()->comment("Event Title");
            $table->text('description')->nullable()->required()->comment("Event Description");
            $table->tinyInteger('all_day')->nullable()->unsigned()->default(0)->comment("All day event disable/enable (0/1)");
            $table->integer('legend_id')->nullable()->unsigned()->default(1)->comment("Legend");
            $table->foreign('legend_id')->references('id')->on('legend')->onDelete('cascade');
            $table->timestamp('start_date')->nullable()->comment("Start date");
            $table->timestamp('end_date')->nullable()->comment("End date");
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
        Schema::dropIfExists('events');
    }
}
