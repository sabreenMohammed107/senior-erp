<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('trans_type_id')->unsigned()->nullable();
            $table->integer('entry_serial')->nullable();
            $table->dateTime('entry_date', 6)->nullable();
            $table->BigInteger('gl_item_id')->unsigned()->nullable();
            $table->float('debit',10,2)->nullable();
            $table->float('credit',10,2)->nullable();
            $table->BigInteger('person_id')->unsigned()->nullable();
            $table->string('person_name', 255)->nullable();
            $table->BigInteger('cash_box_id')->unsigned()->nullable();
            $table->BigInteger('cheque_id')->unsigned()->nullable();
            $table->BigInteger('voucher_id')->unsigned()->nullable();
            $table->BigInteger('stock_id')->unsigned()->nullable();
            $table->text('entry_statment')->nullable();
            $table->BigInteger('branch_id')->unsigned()->nullable();
            $table->BigInteger('bank_id')->unsigned()->nullable();

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
        Schema::dropIfExists('financial_entries');
    }
}
