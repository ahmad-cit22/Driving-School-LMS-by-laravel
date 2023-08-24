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
        Schema::create('vid_course_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_id');
            $table->unsignedBigInteger('enroll_id');
            $table->foreign('enroll_id')->references('id')->on('vid_course_enrolls');
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
        Schema::dropIfExists('vid_course_certificates');
    }
};
