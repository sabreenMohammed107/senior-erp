<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('voucher_type_id')->unsigned()->nullable();
            $table->string('voucher_no', 255)->nullable();
            $table->dateTime('voucher_date', 6)->nullable();
            $table->BigInteger('voucher_ref_type_id')->unsigned()->nullable();
            $table->BigInteger('cash_box_id')->unsigned()->nullable();
            $table->BigInteger('cheque_id')->unsigned()->nullable();
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
        Schema::dropIfExists('vouchers');
    }
}
