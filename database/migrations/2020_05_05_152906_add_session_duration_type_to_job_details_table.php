<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSessionDurationTypeToJobDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_details', function (Blueprint $table) {
            $table->enum('session_duration_type',['min' ,'hour'])->default('hour');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_details', function (Blueprint $table) {
            $table->dropColumn('session_duration_type');
        });
    }
}
