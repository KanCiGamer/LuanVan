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
        Schema::create('seats', function (Blueprint $table) {
            $table->bigIncrements('seat_id');
            $table->string('seat_name',3);
            $table->unsignedBigInteger('cinema_room_id');
            $table->unsignedBigInteger('seat_type_id');
            $table->foreign('cinema_room_id')->references('cinema_room_id')->on('cinema_rooms')->onDelete('cascade');
            $table->foreign('seat_type_id')->references('seat_type_id')->on('seat_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
