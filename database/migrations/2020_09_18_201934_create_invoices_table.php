<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('invoice_type_id')->unsigned()->nullable();
            $table->dateTime('invoice_date', 6)->nullable();
            $table->string('invoice_no', 255)->nullable();
            $table->integer('invoice_serial')->nullable();
            $table->BigInteger('person_id')->unsigned()->nullable();
            $table->string('person_name', 255)->nullable();
            $table->BigInteger('person_type_id')->unsigned()->nullable();
            $table->tinyInteger('purch_invoice_reference')->nullable();
            $table->BigInteger('currency_id')->unsigned()->nullable();
            $table->BigInteger('invoice_status_id')->unsigned()->nullable();
            $table->float('total_items_price', 8, 2)->nullable();
            $table->float('local_net_invoice', 8, 2)->nullable();
            $table->float('exchange_rate', 8, 2)->nullable();
            $table->float('foreign_net_invoice', 8, 2)->nullable();
            $table->tinyInteger('confirmed')->nullable();
            $table->text('notes')->nullable();
            $table->BigInteger('stk_transaction_id')->unsigned()->nullable();
            $table->BigInteger('stock_id')->unsigned()->nullable();
            $table->float('total_invoice_additive', 8, 2)->nullable();
            $table->BigInteger('branch_id')->unsigned()->nullable();
            $table->float('total_disc_value', 8, 2)->nullable();
            $table->tinyInteger('total_bonus_qty')->nullable();
            $table->float('total_vat_value', 8, 2)->nullable();
            $table->BigInteger('sales_rep_id')->unsigned()->nullable();
            $table->BigInteger('marketing_rep_id')->unsigned()->nullable();
            $table->BigInteger('pay_type_id')->unsigned()->nullable();
            $table->integer('print_sales_cnt')->nullable();
            $table->BigInteger('order_id')->unsigned()->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
