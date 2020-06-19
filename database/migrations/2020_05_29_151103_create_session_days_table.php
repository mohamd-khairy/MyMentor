<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('session_id')->index()->nullable();
            $table->unsignedBigInteger('week_days_id')->index()->nullable();
            $table->dateTime('date_time')->nullable();
            $table->string('join_url')->nullable();
            $table->timestamps();


            $table->foreign('session_id')->references('id')
                ->on('sessions')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('week_days_id')->references('id')
                ->on('week_days')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_days');
    }
}