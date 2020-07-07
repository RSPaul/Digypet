<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('pet_type');
            $table->string('pet_icon');
            $table->string('service_type');
            $table->text('description');
            $table->string('price');
            $table->string('price_per_unit');
            $table->string('service_location');
            $table->boolean('share_service')->default(0);
            $table->boolean('share_images')->default(0);
            $table->text('images')->nullable();
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
        Schema::dropIfExists('services');
    }
}
