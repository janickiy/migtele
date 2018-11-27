<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->integer('contractor_type')->nullable();
            $table->string('contractor_name')->nullable();
            $table->string('contractor_phone')->nullable();
            $table->string('contractor_email')->nullable();
            $table->string('contractor_address')->nullable();
            $table->string('contractor_company_name')->nullable();
            $table->string('contractor_organization')->nullable();
            $table->string('contractor_inn')->nullable();
            $table->string('contractor_companyReciever')->nullable();
            $table->string('contractor_companyRecieverAddress')->nullable();
            $table->string('contractor_bankTotal')->nullable();

            $table->string('deliveryAddress')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'contractor_type',
                'contractor_name',
                'contractor_phone',
                'contractor_email',
                'contractor_address',
                'contractor_company_name',
                'contractor_organization',
                'contractor_inn',
                'contractor_companyReciever',
                'contractor_companyRecieverAddress',
                'contractor_bankTotal',
                'deliveryAddress',
            ]);
        });
    }
}
