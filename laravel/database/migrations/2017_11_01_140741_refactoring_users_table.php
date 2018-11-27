<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactoringUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropColumn(['notify_on_status', 'password', 'remember_token', 'subscribe_order']);

        });

        Schema::table('users', function (Blueprint $table) {
            $table->timestamps();
            $table->string('password')->after('comment');
            $table->string('remember_token', 100)->nullable()->after('password');
            $table->boolean('subscribe_order')->after('remember_token')->default(1);
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
            $table->boolean('notify_on_status')->nullable();
        });
    }
}
