<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigInteger('role_id')->unsigned()->primary();
            $table->string('role_name');
            //$table->timestamps();
        });

        DB::table('user_roles')->insert([
            'role_id' => 0, 
            'role_name' => 'user', 
            // 'created_at' => now(), 
            // 'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
