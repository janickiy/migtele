<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('hash')->nullable();

            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('number');
            $table->double('amount');
            $table->text('comment')->nullable();
            $table->boolean('is_pay')->default(0);
            $table->timestamps();
        });

        DB::update("ALTER TABLE ".$_ENV['DB_PREFIX']."pay_orders AUTO_INCREMENT = 1000;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_orders');
    }
}
