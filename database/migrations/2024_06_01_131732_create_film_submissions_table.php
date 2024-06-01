<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->json('tags')->nullable(); // Assuming tags are stored as JSON
            $table->string('length', 5); // HH:MM format
            $table->year('year');
            $table->string('thumbnail');
            $table->string('video_url');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('director_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('film_submissions');
    }
}
