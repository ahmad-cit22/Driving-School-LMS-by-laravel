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
        Schema::create('vid_course_enrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vid_course_id');
            $table->integer('status')->default(0)->comment('0 = Pending, 1 = Approved, 2 = Finished');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('vid_course_id')->references('id')->on('video_courses');
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
        Schema::dropIfExists('vid_course_enrolls');
    }
};
