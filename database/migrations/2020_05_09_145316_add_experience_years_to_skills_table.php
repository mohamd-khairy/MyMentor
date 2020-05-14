<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExperienceYearsToSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('skill_details', function (Blueprint $table) {
            $table->string('experience_years')->after('skill_name')->nullable();
            $table->string('details')->after('skill_name')->nullable();
            $table->string('photo')->after('skill_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skill_details', function (Blueprint $table) {
            $table->dropColumn('experience_years');
            $table->dropColumn('details');
        });
    }
}
