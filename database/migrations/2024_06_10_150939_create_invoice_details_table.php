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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->char('invoice_id', 10);  // mã hóa đơn - khóa ngoại
            $table->unsignedBigInteger('showtime_id');  // mã suất chiếu - khóa ngoại

            $table->double('gia_tien')->nullable(false);  // giá tiền - không để trống
            
            // Đặt khóa chính tổng hợp
            $table->primary(['invoice_id', 'showtime_id']);
            
            // Định nghĩa các khóa ngoại
            $table->foreign('invoice_id')->references('invoice_id')->on('invoices')->onDelete('cascade');
            $table->foreign('showtime_id')->references('showtime_id')->on('show_times')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoie_details');
    }
};
