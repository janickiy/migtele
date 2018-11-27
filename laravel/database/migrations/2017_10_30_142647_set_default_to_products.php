<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetDefaultToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods', function (Blueprint $table) {
            $table->dropColumn(['link', 'text1', 'text2', 'text3', 'text5', 'sp', 'soft', 'hide', 'tr', 'ids_goods']);
        });

        Schema::table('goods', function (Blueprint $table) {
            $table->string('link')->nullable()->after('name');
            $table->text('text1')->nullable()->after('link');
            $table->text('text2')->nullable()->after('text1');
            $table->text('text3')->nullable()->after('text2');
            $table->text('text5')->nullable()->after('text3');
            $table->string('sp')->nullable()->after('yml');
            $table->text('soft')->nullable()->after('none');
            $table->boolean('hide')->nullable()->default(0)->after('soft');
            $table->string('tr')->nullable()->after('sort');
            $table->text('ids_goods')->nullable()->after('nalich');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goods', function (Blueprint $table) {
            //
        });
    }
}
