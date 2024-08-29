<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movie_models', function (Blueprint $table) {
            $table->id();
            $table->string('cover');
            $table->longText('title');
            $table->longText('desp');
            $table->longText('story_line');
            $table->string('director');
            $table->string('release_year');
            $table->string('running_time');
            $table->string('industry')->nullable();
            $table->string('country');
            $table->string('language');
            $table->string('rating')->nullable();
            $table->longText('version')->nullable();
            $table->string('url');
            $table->longText('keyword');
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_models');
    }
};
