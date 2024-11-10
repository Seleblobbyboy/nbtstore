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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('CustomerID'); // Primary key สำหรับลูกค้าแต่ละคน
            $table->unsignedBigInteger('UserID')->unique(); // Foreign key เชื่อมไปยังตาราง users
            $table->string('CustomerName'); // ชื่อลูกค้า
            $table->softDeletes(); // สำหรับ soft delete
            $table->timestamps();

            // กำหนด foreign key constraint
            $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
