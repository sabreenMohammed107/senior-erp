<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsExclusionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_exclusions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('asset_id')->unsigned()->nullable();
            $table->BigInteger('exclusion_type_id')->unsigned()->nullable();
            $table->dateTime('exclusion_date', 6)->nullable();
            $table->string('exclusion_person', 255)->nullable();
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
        Schema::dropIfExists('assets_exclusions');
    }
}
