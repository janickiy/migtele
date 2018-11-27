<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAdvantagesTableAndAddIsadvantagesToPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('advantages');

        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('is_advantage')->nullable()->default(0);
            $table->integer('advantage_order')->nullable()->default(9999);
            $table->string('advantage_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['is_advantage', 'advantage_order', 'advantage_description']);
        });
    }
}
