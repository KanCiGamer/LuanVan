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
        Schema::create('age_ratings', function (Blueprint $table) {
            $table->bigIncrements('age_rating_id');
            $table->string('rating_name', 10);
            $table->string('description');
            //$table->timestamps();
        });

        DB::table('age_ratings')->insert([
            ['rating_name' => 'P', 'description' => 'P: Phim dành cho khán giả mọi lứa tuổi.'],
            ['rating_name' => 'K', 'description' => 'K: Phim dành cho khán giả từ dưới 13 tuổi với điều kiện xem cùng cha, mẹ hoặc người giám hộ.'],
            ['rating_name' => 'T13', 'description' => 'T13: Phim dành cho khán giả từ đủ 13 tuổi trở lên.'],
            ['rating_name' => 'T16', 'description' => 'T16: Phim dành cho khán giả từ đủ 16 tuổi trở lên.'],
            ['rating_name' => 'T18', 'description' => 'T18: Phim dành cho khán giả từ đủ 18 tuổi trở lên.'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('age_ratings');
    }
};
