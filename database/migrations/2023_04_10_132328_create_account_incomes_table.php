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
        Schema::create('account_incomes', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('enroll_id')->nullable();
            $table->longText('note')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('enroll_id')->references('id')->on('enrolls');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('account_incomes');
    }
};
