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
        Schema::create('cinema_rooms', function (Blueprint $table) {
            $table->bigIncrements('cinema_room_id');
            $table->string('cinema_room_name');
            $table->unsignedBigInteger('cinema_id');
            $table->foreign('cinema_id')->references('cinema_id')->on('cinemas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cinema_rooms');
    }
};
