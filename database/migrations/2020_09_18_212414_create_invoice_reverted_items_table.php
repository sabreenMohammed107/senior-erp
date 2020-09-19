<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceRevertedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_reverted_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('invoice_item_id')->unsigned()->nullable();
            $table->BigInteger('transaction_id')->unsigned()->nullable();
            $table->float('item_qty', 8, 2)->nullable();
            $table->float('item_cost', 8, 2)->nullable();
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
        Schema::dropIfExists('invoice_reverted_items');
    }
}
