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
        Schema::create('course_slots', function (Blueprint $table) {
            $table->id();
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedBigInteger('branch_id');
            $table->integer('type')->comment('1 = Practical, 2 = Theory');
            $table->unsignedBigInteger('day')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('day')->references('id')->on('days');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('course_slots');
    }
};
