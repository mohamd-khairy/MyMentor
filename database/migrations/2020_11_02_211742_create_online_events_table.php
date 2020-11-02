<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable();
            $table->string('location')->nullable();
            $table->text('photo')->nullable();
            $table->text('banner')->nullable();
            $table->text('about')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->time('time_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')
            ->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_events');
    }
}
