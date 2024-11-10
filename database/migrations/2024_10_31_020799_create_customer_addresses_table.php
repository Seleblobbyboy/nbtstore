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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id('AddressID'); // Primary key สำหรับที่อยู่แต่ละรายการ
            $table->unsignedBigInteger('CustomerID'); // Foreign key ที่เชื่อมไปยังตาราง customers
            $table->string('CustomerName'); // ชื่อลูกค้า
            $table->text('Address'); // ที่อยู่
            $table->string('PhoneNumber', 20)->nullable(); // เบอร์โทรศัพท์สำหรับที่อยู่นี้
            $table->string('PostalCode', 10)->nullable(); // รหัสไปรษณีย์
            $table->string('Province')->nullable(); // จังหวัด
            $table->string('District')->nullable(); // เขต/อำเภอ
            $table->string('Subdistrict')->nullable(); // แขวง/ตำบล
            $table->timestamps();
            
            // Foreign Key constraint สำหรับ CustomerID เท่านั้น
            $table->foreign('CustomerID')->references('CustomerID')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
