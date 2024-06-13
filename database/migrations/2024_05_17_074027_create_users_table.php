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
        Schema::create('users', function (Blueprint $table) {
            $table->char('user_id',10)->primary();
            $table->string('user_name');
            $table->string('user_phone')->unique();
            $table->string('user_email')->unique();
            $table->string('user_gender');
            $table->date('user_date_of_birth');
            $table->string('user_password');
            $table->bigInteger('role_id')->unsigned();
            $table->boolean('verification')->default(false);
            $table->string('verification_token')->nullable(false);
            $table->boolean('block')->default(false);

            $table->foreign('role_id')->references('role_id')->on('user_roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
