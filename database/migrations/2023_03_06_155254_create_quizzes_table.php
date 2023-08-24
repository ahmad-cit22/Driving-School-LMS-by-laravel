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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('course_type')->nullable();
            $table->string('quiz_name');
            $table->integer('total_questions')->default(0);  // minutes
            $table->integer('total_marks')->default(0);  // minutes
            $table->integer('time_limit')->nullable();  // minutes
            $table->integer('quiz_status')->default(0); // 0 = upcoming, 1 = ongoing, 2 = closed
            // $table->integer('quiz_privacy')->default(0); // 0 = public, 1 = students only 
            $table->foreign('course_id')->references('id')->on('course_categories');
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
        Schema::dropIfExists('quizzes');
    }
};
