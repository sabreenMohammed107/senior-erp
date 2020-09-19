<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255)->nullable();
            $table->string('ar_name', 255)->nullable();
            $table->string('en_name', 255)->nullable();
            $table->string('branch_address', 500)->nullable();
            $table->string('branch_phone', 255)->nullable();
            $table->string('branch_fax', 255)->nullable();
            $table->float('open_balance', 10, 2)->nullable();
            $table->dateTime('balance_start_date', 6)->nullable();
            $table->float('current_balance', 10, 2)->nullable();
            $table->BigInteger('gl_item_id')->unsigned()->nullable();
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
        Schema::dropIfExists('banks');
    }
}
