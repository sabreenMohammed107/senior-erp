<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyGrpsValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_grps_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('property_id')->unsigned()->nullable();
            $table->BigInteger('value_id')->unsigned()->nullable();
            $table->BigInteger('property_group_id')->unsigned()->nullable();

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
        Schema::dropIfExists('property_grps_values');
    }
}
