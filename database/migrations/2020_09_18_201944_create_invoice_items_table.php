<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('item_id')->unsigned()->nullable();
            $table->string('batch_no', 255)->nullable();
            $table->dateTime('expired_date', 6)->nullable();
            $table->BigInteger('property_grp_id')->unsigned()->nullable();
            $table->integer('item_qty')->nullable();
            $table->float('item_price', 8, 2)->nullable();
            $table->float('total_line_cost', 8, 2)->nullable();
            $table->BigInteger('invoice_id')->unsigned()->nullable();
            $table->BigInteger('additive_item_id')->unsigned()->nullable();
            $table->text('notes')->nullable();
            $table->float('additive_item_value', 8, 2)->nullable();
            $table->float('total_line_post_add_item', 8, 2)->nullable();
            $table->float('item_disc_value', 8, 2)->nullable();
            $table->float('item_bonus_qty', 8, 2)->nullable();
            $table->float('item_vat_value', 8, 2)->nullable();
            $table->float('item_vat_perc', 8, 2)->nullable();
            $table->float('item_disc_perc', 8, 2)->nullable();
            $table->float('final_line_cost', 8, 2)->nullable();
            $table->integer('reverted_item_qty_total')->nullable();
            $table->integer('reverted_item_qty_bonus_total')->nullable();

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
        Schema::dropIfExists('invoice_items');
    }
}
