<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->unsignedBigInteger('category_id')->index()->nullable();
            $table->unsignedBigInteger('language_id')->index()->nullable();
            $table->string('topic')->index()->nullable();
            $table->string('subject')->index()->nullable();
            $table->text('details')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')
            ->on('categories')->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('language_id')->references('id')
            ->on('languages')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('topics');
    }
}
