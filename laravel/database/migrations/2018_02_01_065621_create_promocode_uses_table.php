<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromocodeUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocode_uses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->dateTime('used_at');

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
        Schema::dropIfExists('promocode_uses');
    }
}
