<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetHistoricalMovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_historical_moves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('fixed_asset_id')->unsigned()->nullable();
            $table->dateTime('move_date', 6)->nullable();
            $table->BigInteger('barnch_from_id')->unsigned()->nullable();
            $table->BigInteger('branch_to_id')->unsigned()->nullable();
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
        Schema::dropIfExists('asset_historical_moves');
    }
}
