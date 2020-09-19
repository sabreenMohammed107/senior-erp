<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTakingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_takings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('taking_date', 6)->nullable();
            $table->string('taking_no', 255)->nullable();
            $table->BigInteger('stock_id')->unsigned()->nullable();
            $table->BigInteger('stock_taking_status_id')->unsigned()->nullable();
            $table->BigInteger('person_id')->unsigned()->nullable();
            $table->BigInteger('responsible_emp_id')->unsigned()->nullable();
            $table->BigInteger('responsible_emp2_id')->unsigned()->nullable();
            $table->BigInteger('responsible_emp3_id')->unsigned()->nullable();

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
        Schema::dropIfExists('stock_takings');
    }
}
