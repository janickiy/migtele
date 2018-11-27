<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->increments('id');

            $table->string('type')->default("1");

            $table->string('email');
            $table->string('name');
            $table->string('phone');

            $table->string('mobile_phone')->nullable();

            $table->string('address')->nullable();

            $table->string('organization')->nullable();
            $table->string('inn')->nullable();

            $table->string('company_receiver')->nullable();
            $table->string('company_receiver_address')->nullable();

            $table->string('fact_address')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('delivery_address_2')->nullable();

            $table->string('bank_total')->nullable();
            $table->string('passport_number')->nullable();

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
        Schema::dropIfExists('contractors');
    }
}
