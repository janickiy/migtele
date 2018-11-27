<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductToCallOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('call_orders', function (Blueprint $table) {
            $table->integer('product_id')->nullable()->unsigned();
            $table->integer('products_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('call_orders', function (Blueprint $table) {
            $table->dropColumn(['product_id', 'products_count']);
        });
    }
}
