<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255)->nullable();
            $table->dateTime('transaction_date', 6)->nullable();
            $table->tinyInteger('referance_type')->nullable();
            $table->BigInteger('order_id')->unsigned()->nullable();
            $table->BigInteger('transaction_type_id')->unsigned()->nullable();
            $table->BigInteger('primary_stock_id')->unsigned()->nullable();
            $table->BigInteger('person_id')->unsigned()->nullable();
            $table->string('person_name', 255)->nullable();
            $table->BigInteger('person_type_id')->unsigned()->nullable();
            $table->BigInteger('invoice_id')->unsigned()->nullable();
            $table->string('permission_code', 255)->nullable();
            $table->dateTime('permission_date', 6)->nullable();
            $table->BigInteger('secondary_stock_id')->unsigned()->nullable();
            $table->tinyInteger('confirmed')->nullable();
            $table->text('notes')->nullable();
            $table->integer('drive_id')->nullable();
            $table->string('car_no', 255)->nullable();
            $table->tinyInteger('rcvd_confirmed')->nullable();
            $table->BigInteger('parent_tranaction_id')->unsigned()->nullable();
            $table->float('total_items_price',8,2)->nullable();
            $table->float('local_net_invoice',8,2)->nullable();
            $table->float('foreign_net_invoice',8,2)->nullable();
            $table->float('total_disc_value',8,2)->nullable();
            $table->float('total_bonus_qty',8,2)->nullable();
            $table->float('total_vat_value',8,2)->nullable();

            














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
        Schema::dropIfExists('stocks_transactions');
    }
}
