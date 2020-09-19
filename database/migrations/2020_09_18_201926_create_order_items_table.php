<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('item_id')->unsigned()->nullable();
            $table->string('batch_no', 255)->nullable();
            $table->dateTime('expired_date', 6)->nullable();
            $table->BigInteger('property_grp_id')->unsigned()->nullable();
            $table->integer('item_qty')->nullable();
            $table->float('item_price', 8, 2)->nullable();
            $table->float('total_line_cost', 8, 2)->nullable();
            $table->BigInteger('order_id')->unsigned()->nullable();
            $table->text('notes')->nullable();
            $table->float('item_disc_perc', 10, 2)->nullable();
            $table->float('item_disc_value', 10, 2)->nullable();
            $table->float('final_line_cost', 10, 2)->nullable();
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
        Schema::dropIfExists('order_items');
    }
}
