<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewDirectorToFilmSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('film_submissions', function (Blueprint $table) {
            $table->string('new_director')->nullable()->after('director_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('film_submissions', function (Blueprint $table) {
            $table->dropColumn('new_director');
        });
    }
}

