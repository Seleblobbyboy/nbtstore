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
            $table->id('InvoiceID');
            $table->unsignedBigInteger('AddressID'); 
            $table->unsignedBigInteger('CustomerID'); // เชื่อมโยงกับตาราง customers
            $table->string('FullName');               // ชื่อนามสกุล
            $table->string('IDCardNumber', 20);       // เลขที่บัตรประชาชน
            $table->string('PhoneNumber', 20);        // เบอร์โทรศัพท์
            $table->text('Address')->nullable();      // ที่อยู่
            $table->string('PostalCode', 10)->nullable(); // รหัสไปรษณีย์
            $table->string('Province')->nullable();   // จังหวัด
            $table->string('District')->nullable();   // อำเภอ
            $table->string('Subdistrict')->nullable();// แขวง/ตำบล
            $table->timestamps();
    
            // เชื่อมโยง Foreign Key กับตาราง customers และ customer_addresses
            $table->foreign('CustomerID')->references('CustomerID')->on('customers')->onDelete('cascade');
            $table->foreign('AddressID')->references('AddressID')->on('customer_addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
