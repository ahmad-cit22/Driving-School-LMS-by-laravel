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
        Schema::create('banner_parts', function (Blueprint $table) {
            $table->id();
            $table->string('logo_image')->nullable();
            $table->string('banner_img')->nullable();
            $table->string('subtitle');
            $table->string('title');
            $table->string('bottom_text')->nullable();
            $table->string('button_one_name')->nullable();
            $table->string('button_two_name')->nullable();
            $table->string('button_one_link')->nullable();
            $table->string('button_two_link')->nullable();
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
        Schema::dropIfExists('banner_parts');
    }
};
