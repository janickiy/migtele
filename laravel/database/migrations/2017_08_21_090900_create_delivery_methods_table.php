<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->text('description')->nullable();
            $table->integer('price')->nullable();

            $table->string('map_file')->nullable();
            $table->string('coordinate')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('days')->nullable();
            $table->string('hours')->nullable();

            $table->text('text_to_store')->nullable();
            $table->text('text_to_door')->nullable();

            $table->boolean('hide')->nullable();
            $table->integer('sort')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_methods');
    }
}
