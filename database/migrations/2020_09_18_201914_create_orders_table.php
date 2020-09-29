<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('purch_order_no', 255)->nullable();
            $table->integer('order_serial')->nullable();
            $table->tinyInteger('order_type_id')->nullable();
            $table->dateTime('order_date', 6)->nullable();
            $table->BigInteger('branch_id')->unsigned()->nullable();
            $table->BigInteger('person_id')->unsigned()->nullable();
            $table->BigInteger('stock_id')->unsigned()->nullable();
            $table->string('person_name', 255)->nullable();
            $table->BigInteger('person_type_id')->unsigned()->nullable();
            $table->dateTime('received_date_suggested', 6)->nullable();
            $table->BigInteger('currency_id')->unsigned()->nullable();
            $table->float('exchange_rate', 8, 2)->nullable();
            $table->text('order_description')->nullable();
            $table->BigInteger('order_status_id')->unsigned()->nullable();
            $table->BigInteger('order_decision_status_id')->unsigned()->nullable();
            $table->float('order_value', 8, 2)->nullable();
            $table->BigInteger('purchasing_order_type_id')->unsigned()->nullable();
            $table->tinyInteger('confirmed')->nullable();
            $table->BigInteger('confirmed_emp_id')->unsigned()->nullable();
            $table->text('notes')->nullable();
            $table->float('total_disc_value', 8, 2)->nullable();
            $table->float('total_final_cost', 8, 2)->nullable();
            $table->BigInteger('sales_rep_id')->unsigned()->nullable();
            $table->BigInteger('marketing_rep_id')->unsigned()->nullable();
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
        Schema::dropIfExists('orders');
    }
}
