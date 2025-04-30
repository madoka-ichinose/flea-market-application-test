<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSellerIdAndBuyerIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('seller_id')->after('id');
            $table->unsignedBigInteger('buyer_id')->nullable()->after('seller_id');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('seller_id');
            $table->dropColumn('buyer_id');
        });
    }
}
