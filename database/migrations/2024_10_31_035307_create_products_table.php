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
        Schema::create('products', function (Blueprint $table) {
            $table->char('ProductID', 5)->primary();
            $table->string('ProductName');
            $table->string('ProductName_ENG');
            $table->decimal('Price', 10, 2);
            $table->decimal('stock', 10, 2);
            $table->text('Description')->nullable();
            $table->unsignedBigInteger('CategoryID'); // ต้องตรงกัน
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('CategoryID')->references('CategoryID')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
