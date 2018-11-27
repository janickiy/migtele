<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryMethodItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_method_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('delivery_method_id')->unsigned();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('hide')->nullable();
            $table->integer('sort')->nullable();
        });

        Schema::table('delivery_method_items', function (Blueprint $table) {
            $table->foreign('delivery_method_id')->references('id')->on('delivery_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_method_items', function (Blueprint $table) {
            $table->dropForeign(['delivery_method_id']);
        });

        Schema::dropIfExists('delivery_method_items');
    }
}
