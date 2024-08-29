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
        Schema::create('comment_models', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_id')->nullable();
            $table->string('movie_id')->nullable();
            $table->string('comment');
            $table->string('like')->nullable();
            $table->string('dislike')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_models');
    }
};
