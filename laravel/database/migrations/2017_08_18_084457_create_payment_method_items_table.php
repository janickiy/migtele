<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentMethodItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_method_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_method_id')->unsigned();
            $table->string('name')->nullable();
            $table->integer('sort')->nullable()->default(999999999);
            $table->boolean('hide')->nullable();
        });

        Schema::table('payment_method_items', function (Blueprint $table) {
           $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('payment_method_items', function (Blueprint $table) {
            $table->dropForeign(['payment_method_id']);
        });*/
        Schema::dropIfExists('payment_method_items');
    }
}
