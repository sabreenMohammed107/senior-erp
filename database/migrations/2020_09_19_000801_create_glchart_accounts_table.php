<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlchartAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('glchart_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255)->nullable();
            $table->string('ar_name', 255)->nullable();
            $table->string('en_name', 255)->nullable();
            $table->tinyInteger('gl_item_level')->nullable();
            $table->BigInteger('parent_id')->unsigned()->nullable();
            $table->tinyInteger('system_item')->nullable();
            $table->float('open_balance',8,2)->nullable();
            $table->dateTime('open_balance_date', 6)->nullable();
            $table->tinyInteger('balance_type')->nullable();
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
        Schema::dropIfExists('glchart_accounts');
    }
}
