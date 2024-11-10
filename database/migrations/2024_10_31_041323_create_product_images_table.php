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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id('ImageID');
            $table->char('ProductID', 5);  // Foreign Key เชื่อมกับ products
            $table->string('ImagePath');   // เก็บเส้นทางของไฟล์รูปภาพ
            $table->string('AltText')->nullable(); // ข้อความอธิบายรูป (Optional)
            $table->timestamps();

            // Foreign Key constraint
            $table->foreign('ProductID')->references('ProductID')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
