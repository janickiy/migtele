<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveryTextAndGarantyTextToCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cattype', function (Blueprint $table) {
            $table->text('delivery_text')->nullable();
            $table->text('warranty_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cattype', function (Blueprint $table) {
            $table->dropColumn(['delivery_text', 'warranty_text']);
        });
    }
}
