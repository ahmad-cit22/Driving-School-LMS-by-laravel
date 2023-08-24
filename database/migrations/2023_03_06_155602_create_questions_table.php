<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->integer('quiz_id');
            $table->integer('course_id');
            $table->integer('course_type')->nullable(); //1=short, 2=long
            $table->string('question');
            $table->integer('question_type')->default(0); // 0 = MCQ, 1=true/false, 2=descriptive
            $table->integer('right_answer'); // 0 = MCQ, 1=true/false, 2=descriptive
            $table->integer('marks')->default(1);
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
        Schema::dropIfExists('questions');
    }
};
