<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('item_pricing_type_id')->unsigned()->nullable();
            $table->BigInteger('item_id')->unsigned()->nullable();
            $table->BigInteger('client_category_id')->unsigned()->nullable();
            $table->BigInteger('client_id')->unsigned()->nullable();
            $table->float('item_price',8,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items_prices');
    }
}
