<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('post_code', 5); // รหัสไปรษณีย์
            $table->string('tambon_id', 10); // รหัสตำบล
            $table->string('tambon_thai_short', 100); // ชื่อตำบลภาษาไทย
            $table->string('district_thai_short', 100); // ชื่ออำเภอภาษาไทย
            $table->string('province_thai', 100); // ชื่อจังหวัดภาษาไทย
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
