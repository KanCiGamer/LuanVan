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
        Schema::create('movies', function (Blueprint $table) {
        $table->uuid('movie_id')->primary();
        $table->string('movie_name')->nullable(false); 
        $table->string('nation')->nullable(false);
        $table->string('directors')->nullable(false);
        $table->string('actor')->nullable(false);
        $table->string('language')->nullable(false);
        $table->text('description')->nullable(false);
        $table->string('poster')->nullable(false);
        $table->string('trailer_link')->nullable(false); 
        $table->integer('time')->nullable(false); 
        $table->integer('price')->nullable(false); 
        $table->boolean('status')->default(true);
        $table->unsignedBigInteger('age_rating_id')->nullable(false);
        $table->foreign('age_rating_id')->references('age_rating_id')->on('age_ratings')->onDelete('cascade');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
