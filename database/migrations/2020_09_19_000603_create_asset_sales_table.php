<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('fixed_asset_id')->unsigned()->nullable();
            $table->BigInteger('client_id')->unsigned()->nullable();
            $table->float('sale_price',10,2)->nullable();
            $table->tinyInteger('bank_type')->nullable();
            $table->BigInteger('cheuqe_id')->unsigned()->nullable();
            $table->BigInteger('cash_box_id')->unsigned()->nullable();
            $table->tinyInteger('confirm')->nullable();
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
        Schema::dropIfExists('asset_sales');
    }
}
