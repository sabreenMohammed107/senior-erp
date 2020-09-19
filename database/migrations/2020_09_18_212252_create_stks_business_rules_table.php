<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStksBusinessRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stks_business_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_text', 255)->nullable();
            $table->string('en_text', 255)->nullable();
            $table->tinyInteger('active')->nullable();

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
        Schema::dropIfExists('stks_business_rules');
    }
}
