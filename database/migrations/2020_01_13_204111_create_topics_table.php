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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('language_id')->nullable();
            $table->string('topic')->nullable();
            $table->string('subject')->nullable();
            $table->text('details')->nullable();

            $table->foreign('category_id')->references('id')
            ->on('categories')->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('language_id')->references('id')
            ->on('languages')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('topics');
    }
}
