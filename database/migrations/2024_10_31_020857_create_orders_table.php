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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('OrderID', 20)->primary();
            $table->dateTime('OrderDate');
            $table->unsignedBigInteger('CustomerID');
            $table->unsignedBigInteger('AddressID')->nullable();
            $table->decimal('TotalAmount', 10, 2);
            $table->string('SlipImage')->nullable();
            $table->integer('confirm')->nullable(); // สามารถเป็นเลขใดก็ได้ และเป็นค่าว่างได้
            $table->string('Comment')->nullable();
            $table->string('taxid')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // เปลี่ยนจาก tinyInteger เป็น integer และให้สามารถรับค่าใดๆ ได้

            $table->foreign('CustomerID')->references('CustomerID')->on('customers')->onDelete('cascade');
            $table->foreign('AddressID')->references('AddressID')->on('customer_addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
