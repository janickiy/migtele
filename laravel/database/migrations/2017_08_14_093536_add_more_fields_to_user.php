<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldsToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('type');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();

            $table->string('delivery_address')->nullable();

            $table->string('company_name')->nullable();
            $table->string('tin')->nullable();
            $table->string('juridical_address')->nullable();
            $table->string('actual_address')->nullable();

            $table->boolean('news_subscribe')->nullable();
            $table->boolean('notification_in_email')->nullable();


            $table->dropColumn(['name']);
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

            $table->string('name');

            $table->dropColumn([
                'type',
                'first_name',
                'last_name',
                'phone',
                'delivery_address',
                'company_name',
                'tin',
                'juridical_address',
                'actual_address',
                'news_subscribe',
                'notification_in_email'
            ]);


        });
    }
}
