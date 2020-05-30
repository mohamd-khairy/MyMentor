<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_give_id')->nullable();
            $table->unsignedBigInteger('user_recieve_id')->nullable();
            $table->unsignedBigInteger('day_id')->nullable();
            $table->string('duration')->nullable();

            $table->text('details')->nullable();

            $table->foreign('day_id')->references('id')
            ->on('week_days')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_give_id')->references('id')
            ->on('users')->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('user_recieve_id')->references('id')
            ->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('sessions');
    }
}
