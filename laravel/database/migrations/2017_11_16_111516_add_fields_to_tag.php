<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->nullable()->after('slug');
            $table->integer('subcategory_id')->unsigned()->nullable()->after('category_id');
            $table->text('text')->nullable()->after('subcategory_id');
            $table->text('delivery_text')->nullable()->after('text');
            $table->text('warranty_text')->nullable()->after('delivery_text');
            $table->string('title')->nullable()->after('warranty_text');
            $table->text('description')->nullable()->after('title');
            $table->string('keywords')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn(['category_id', 'subcategory_id', 'text', 'delivery_text', 'warranty_text', 'title', 'description', 'keywords']);
        });
    }
}
