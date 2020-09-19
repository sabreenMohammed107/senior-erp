<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255)->nullable();
            $table->string('ar_name', 255)->nullable();
            $table->string('en_name', 255)->nullable();
            $table->tinyInteger('is_main_stock')->nullable();
            $table->BigInteger('stock_type_id')->unsigned()->nullable();
            $table->BigInteger('branch_id')->unsigned()->nullable();
            $table->BigInteger('responsible_emp_id')->unsigned()->nullable();
            $table->BigInteger('stock_taking_emp_id')->unsigned()->nullable();
            $table->dateTime('stock_taking_last_date', 6)->nullable();
            $table->tinyInteger('has_open_balance')->nullable();
            $table->dateTime('open_balance_date', 6)->nullable();
            $table->integer('apply_all_grp_category')->nullable();
            $table->tinyInteger('apply_all_stk_operations')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
