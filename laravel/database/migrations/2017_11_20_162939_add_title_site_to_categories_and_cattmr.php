<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleSiteToCategoriesAndCattmr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('catrazdel', function (Blueprint $table) {
            $table->string('content_title')->nullable()->after('name');
        });

        Schema::table('cattmr', function (Blueprint $table) {
            $table->string('content_title')->nullable()->after('id_catrazdel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catrazdel', function (Blueprint $table) {
            $table->dropColumn('content_title');
        });

        Schema::table('cattmr', function (Blueprint $table) {
            $table->dropColumn('content_title');
        });
    }
}
