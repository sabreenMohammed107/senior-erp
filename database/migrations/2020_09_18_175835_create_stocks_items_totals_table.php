<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksItemsTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks_items_totals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('stock_id')->unsigned()->nullable();
            $table->BigInteger('item_id')->unsigned()->nullable();
            $table->string('batch_no', 255)->nullable();
            $table->dateTime('expired_date', 6)->nullable();
            $table->integer('item_total_qty')->nullable();
            $table->integer('item_qty_unconfirmed')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('stocks_items_totals');
    }
}
