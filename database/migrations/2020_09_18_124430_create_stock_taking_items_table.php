<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTakingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_taking_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('stock_taking_id')->unsigned()->nullable();
            $table->BigInteger('item_id')->unsigned()->nullable();
            $table->string('batch_no', 255)->nullable();
            $table->dateTime('expired_date', 6)->nullable();
            $table->BigInteger('property_group_id')->unsigned()->nullable();
            $table->integer('system_qty')->nullable();
            $table->integer('physical_qty')->nullable();
            $table->integer('additive_qty')->nullable();
            $table->float('additive_cost',8, 2)->nullable();
            $table->integer('subtractive_qty')->nullable();
            $table->float('subtractive_cost',8, 2)->nullable();
            $table->tinyInteger('settlement_done')->nullable();



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
        Schema::dropIfExists('stock_taking_items');
    }
}
