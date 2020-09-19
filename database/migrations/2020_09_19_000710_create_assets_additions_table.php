<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsAdditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_additions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_no', 255)->nullable();
            $table->dateTime('invoice_date', 6)->nullable();
            $table->float('invoice_value',8,2)->nullable();
            $table->BigInteger('supplier_id')->unsigned()->nullable();
            $table->BigInteger('fixed_asset_id')->unsigned()->nullable();
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
        Schema::dropIfExists('assets_additions');
    }
}
