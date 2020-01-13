<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_recieve_id')->nullable();
            $table->unsignedBigInteger('user_pay_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('total_price')->nullable();

            $table->foreign('user_recieve_id')->references('id')
            ->on('users')->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('user_pay_id')->references('id')
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
        Schema::dropIfExists('payments');
    }
}
