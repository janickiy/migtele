<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagerLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_manager_logs', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('ip_manager_id');
            $table->string('hash');

            $table->dateTime('start');
            $table->dateTime('end');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('ip_manager_logs');
    }
}
