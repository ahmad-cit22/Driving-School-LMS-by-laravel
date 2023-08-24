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
        Schema::create('video_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_category');
            $table->unsignedBigInteger('course_type')->nullable();
            $table->string('image');
            $table->string('course_title');
            $table->longText('meta_description')->nullable();
            $table->foreign('course_category')->references('id')->on('course_categories');
            $table->foreign('course_type')->references('id')->on('course_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('video_courses');
    }
};
