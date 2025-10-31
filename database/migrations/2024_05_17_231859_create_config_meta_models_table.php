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
        Schema::create('config_meta_models', function (Blueprint $table) {
            $table->id();
            $table->string('owner')->nullable();
            $table->string('type')->nullable();
            $table->string('site_name')->nullable();
            $table->longText('verify')->nullable();
            $table->string('local')->nullable();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->string('desp')->nullable();
            $table->string('keyword')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_meta_models');
    }
};
