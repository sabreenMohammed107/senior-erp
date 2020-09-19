<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('voucher_id')->unsigned()->nullable();
            $table->BigInteger('item_type_ref_id')->unsigned()->nullable();
            $table->BigInteger('gl_item_id')->unsigned()->nullable();
            $table->float('debit',8,2)->nullable();
            $table->float('credit',8,2)->nullable();
            $table->BigInteger('person_id')->unsigned()->nullable();
            $table->string('person_name', 255)->nullable();
            $table->text('entry_statment')->nullable();

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
        Schema::dropIfExists('voucher_items');
    }
}
