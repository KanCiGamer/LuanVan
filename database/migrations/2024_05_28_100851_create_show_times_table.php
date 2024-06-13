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
        Schema::create('show_times', function (Blueprint $table) {
            $table->bigIncrements('showtime_id');
            $table->date('start_date');
            $table->time('start_time');

            $table->uuid('movie_id');
            $table->foreign('movie_id')->references('movie_id')->on('movies')->onDelete('cascade');

            $table->unsignedBigInteger('cinema_room_id');
            $table->foreign('cinema_room_id')->references('cinema_room_id')->on('cinema_rooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('show_times');
    }
};
