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
        Schema::create('enrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('course_category');
            $table->unsignedBigInteger('course_type');
            $table->unsignedBigInteger('course_slot');
            $table->integer('price');
            $table->integer('discount')->nullable();
            $table->integer('payable_amount');
            $table->integer('payment_process')->comment('1 = Online, 2 = Offline');
            $table->integer('paid')->nullable();
            $table->integer('payment_status')->default(0)->comment('0 = Pending, 1 = Has Due, 2 = Completed');
            $table->date('start_date');
            $table->integer('status')->default(0)->comment('0 = Pending, 1 = Approved, 2 = Finished');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('CASCADE');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('CASCADE');
            $table->foreign('course_category')->references('id')->on('course_categories')->onDelete('CASCADE');
            $table->foreign('course_type')->references('id')->on('course_types')->onDelete('CASCADE');
            $table->foreign('course_slot')->references('id')->on('course_slots')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('enrolls');
    }
};
