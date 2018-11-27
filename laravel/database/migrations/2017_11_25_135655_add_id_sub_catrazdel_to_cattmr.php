<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdSubCatrazdelToCattmr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cattmr', function (Blueprint $table) {
            $table->integer('id_sub_catrazdel')->unsigned()->nullable()->after('id_catrazdel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cattmr', function (Blueprint $table) {
            $table->dropColumn('id_sub_catrazdel');
        });
    }
}
