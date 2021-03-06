<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteLoginSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_login_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('site_id')->unsigned()->nullable();
            $table->BigInteger('day_id')->unsigned()->nullable();
            $table->dateTime('from_date', 6)->nullable();
            $table->dateTime('to_date', 6)->nullable();
            $table->tinyInteger('holiday')->nullable();
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
        Schema::dropIfExists('site_login_schedules');
    }
}
