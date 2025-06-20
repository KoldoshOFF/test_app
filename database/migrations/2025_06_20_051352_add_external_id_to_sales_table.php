<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExternalIdToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('external_id')->after('account_id');
            $table->unique(['external_id', 'account_id'], 'sales_external_account_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('sales', function (Blueprint $table) {
            $table->dropUnique('sales_external_account_unique');
            $table->dropColumn('external_id');
        });
    }
}
