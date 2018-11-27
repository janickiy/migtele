<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('first_name', 'name');
            $table->renameColumn('subscribe', 'subscribe_order');
            $table->dropColumn(['last_name']);
            $table->boolean('subscribe_cart')->default(1);
            $table->boolean('subscribe_view')->default(1);
            $table->boolean('subscribe_wishlist')->default(1);
            $table->boolean('subscribe_news')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'first_name');
            $table->renameColumn('subscribe_order', 'subscribe');
            $table->string('last_name')->nullable();
            $table->dropColumn(['name', 'subscribe_cart', 'subscribe_view', 'subscribe_wishlist', 'subscribe_news']);
        });
    }
}
