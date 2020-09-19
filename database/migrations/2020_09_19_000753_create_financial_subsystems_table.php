<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialSubsystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_subsystems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_name', 255)->nullable();
            $table->string('en_name', 255)->nullable();
            $table->tinyInteger('finance_system_type')->nullable();
            $table->BigInteger('gl_item_id')->unsigned()->nullable();
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
        Schema::dropIfExists('financial_subsystems');
    }
}
