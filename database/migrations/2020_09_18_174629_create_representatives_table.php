<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepresentativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('representatives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_name', 255)->nullable();
            $table->string('code', 255)->nullable();
            $table->string('en_name', 255)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('rep_nid', 50)->nullable();
            $table->BigInteger('rep_type_id')->unsigned()->nullable();
            $table->BigInteger('branch_id')->unsigned()->nullable();
            $table->BigInteger('employee_id')->unsigned()->nullable();
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
        Schema::dropIfExists('representatives');
    }
}
