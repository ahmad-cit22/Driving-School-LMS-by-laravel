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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code');
            $table->integer('coupon_type')->comment('1 = Solid, 2 = Percentage');
            $table->integer('discount_amount');
            $table->integer('available_for')->comment('1 = For all courses, other than 1 = For a specific course')->default(1);
            $table->integer('branch_id')->comment('1 = For all branches, other than 1 = For a specific branch')->default(1);
            $table->integer('limit')->nullable()->comment('Needed when coupon type is Percentage');
            $table->date('validity')->nullable();
            $table->integer('status')->comment('1 = Inactive, 2 = Active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('coupons');
    }
};
