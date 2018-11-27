<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromocodeCreatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocode_creators', function (Blueprint $table) {

            $table->increments('id');
            $table->string('email');
            $table->string('name')->nullable();

            $table->boolean('friend_promocode_active')->nullable();

            $table->unsignedInteger('promocode_id');

            $table->foreign('promocode_id')->references('id')->on('promocodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promocode_creators');
    }
}
