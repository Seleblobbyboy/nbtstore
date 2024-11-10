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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('OrderDetailID');
            $table->string('OrderID', 20); // ใช้ string และความยาวที่ตรงกับ orders
            $table->char('ProductID', 5);
            $table->integer('Quantity');
            $table->decimal('SubTotal', 10, 2);
           
            $table->softDeletes();  // Adding soft delete
            $table->timestamps();

            $table->foreign('OrderID')->references('OrderID')->on('orders')->onDelete('cascade');
            $table->foreign('ProductID')->references('ProductID')->on('products')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
