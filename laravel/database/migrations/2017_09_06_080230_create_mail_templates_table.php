<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_templates', function (Blueprint $table) {

            $table->increments('id');
            $table->string('key');
            $table->string('name');
            $table->string('subject');
            $table->string('title');
            $table->string('description')->nullable();
            $table->text('shortcodes')->nullable();
            $table->text('body');
            $table->text('footer')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_templates');
    }
}
