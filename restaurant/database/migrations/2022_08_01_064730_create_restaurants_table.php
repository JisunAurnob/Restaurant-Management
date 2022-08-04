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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('restaurant_name');
            $table->string('address');
            $table->string('restaurant_type');
            $table->string('phone','22');
            $table->string('email')->nullable();
            $table->string('slogan');
            $table->string('restaurant_photo');
            $table->string('bg_photo')->nullable();
            $table->string('opening_time',15);
            $table->string('closing_time',15);
            $table->string('business_days');
            $table->string('slug');
            $table->unsignedBigInteger('client_id');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
};
