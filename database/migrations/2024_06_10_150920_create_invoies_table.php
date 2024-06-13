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
        Schema::create('invoices', function (Blueprint $table) {
            $table->char('invoice_id',10)->primary();    // mã hóa đơn - khóa chính
            $table->date('date_created')->nullable(false); // ngày tạo hóa đơn - không để trống
            $table->boolean('status')->nullable(false); // trạng thái hóa đơn (true: đã duyệt / false: chưa duyệt) - không để trống
            $table->string('email_kh',50)->nullable(false); //email người dùng - không để trống / trùng
            $table->char('user_id',10)->nullable(); // cột mã khách hàng
            $table->foreign('user_id')->references('user_id')->on('users'); // liên kết mã đến bảng khách hàng (khóa ngoại)

            $table->unsignedBigInteger('discount_code_id')->nullable(); // cột mã giảm giá
            $table->foreign('discount_code_id')->references('id')->on('discount_codes'); // liên kết mã giảm giá đến bảng discount_codes (khóa ngoại)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoies');
    }
};
