<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->text('available_days')->nullable(); //array
            $table->text('available_langs')->nullable(); //array
            $table->string('session_price')->nullable();
            $table->string('session_duration')->nullable();
            $table->enum('session_duration_type',['min' ,'hour'])->default('hour');

            $table->string('current_job')->nullable();
            $table->string('current_company')->nullable();
            $table->string('brief')->nullable();

            $table->foreign('user_id')->references('id')
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
        Schema::dropIfExists('job_details');
    }
}
