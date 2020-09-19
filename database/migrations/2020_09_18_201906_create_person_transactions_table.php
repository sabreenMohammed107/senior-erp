<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('person_id')->unsigned()->nullable();
            $table->dateTime('transaction_date', 6)->nullable();
            $table->float('additive_value', 8, 2)->nullable();
            $table->float('subtractive_value', 8, 2)->nullable();
            $table->BigInteger('invoice_id')->unsigned()->nullable();
            $table->BigInteger('invoice_type_id')->unsigned()->nullable();
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
        Schema::dropIfExists('person_transactions');
    }
}
