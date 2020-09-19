<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChequesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cheque_no', 255)->nullable();
            $table->dateTime('transaction_date', 6)->nullable();
            $table->BigInteger('person_id')->unsigned()->nullable();
            $table->string('person_name', 255)->nullable();
            $table->BigInteger('bank_id')->unsigned()->nullable();
            $table->string('bank_name', 255)->nullable();
            $table->dateTime('release_date', 6)->nullable();
            $table->dateTime('due_date', 6)->nullable();
            $table->BigInteger('cheque_type_id')->unsigned()->nullable();
            $table->float('amount',10,2)->nullable();
            $table->string('image', 255)->nullable();
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
        Schema::dropIfExists('cheques');
    }
}
