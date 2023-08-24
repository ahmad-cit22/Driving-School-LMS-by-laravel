<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('type_id');
            $table->string('image')->default('def-image.jpg');
            $table->integer('price');
            $table->integer('discount')->default(0); // in percentage
            $table->integer('after_discount');
            $table->longText('course_details')->nullable();
            $table->longText('meta_description')->nullable();
            $table->integer('priority')->nullable();
            $table->foreign('category_id')->references('id')->on('course_categories');
            $table->foreign('type_id')->references('id')->on('course_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('courses');
    }
};
