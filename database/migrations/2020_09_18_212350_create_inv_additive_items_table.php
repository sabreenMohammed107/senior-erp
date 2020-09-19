<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvAdditiveItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_additive_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('invoice_id')->unsigned()->nullable();
            $table->BigInteger('additive_item_id')->unsigned()->nullable();
            $table->float('additive_item_value', 8, 2)->nullable();
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
        Schema::dropIfExists('inv_additive_items');
    }
}
