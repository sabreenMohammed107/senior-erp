<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('category_id')->unsigned()->nullable();
            $table->string('code', 255)->nullable();
            $table->string('ar_name', 255)->nullable();
            $table->string('en_name', 255)->nullable();
            $table->string('cost_center', 255)->nullable();
            $table->BigInteger('status_id')->unsigned()->nullable();
            $table->BigInteger('supplier_id')->unsigned()->nullable();
            $table->float('purch_value',8,2)->nullable();
            $table->dateTime('purch_date', 6)->nullable();
            $table->string('invoice_no', 255)->nullable();
            $table->float('total_additive_value',8,2)->nullable();
            $table->dateTime('start_date', 6)->nullable();
            $table->dateTime('end_date', 6)->nullable();
            $table->float('total_deprecated',8,2)->nullable();
            $table->float('book_value',8,2)->nullable();
            $table->float('selvage_value',8,2)->nullable();
            $table->BigInteger('person_keeping')->nullable();
            $table->BigInteger('client_id')->unsigned()->nullable();
            $table->float('sales_value',8,2)->nullable();
            $table->dateTime('sales_date', 6)->nullable();
            $table->dateTime('exclusion_date', 6)->nullable();
            $table->tinyInteger('sale_flag')->nullable();
            $table->tinyInteger('exclusion_flag')->nullable();
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
        Schema::dropIfExists('fixed_assets');
    }
}
