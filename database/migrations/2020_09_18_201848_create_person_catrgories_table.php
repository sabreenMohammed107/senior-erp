<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonCatrgoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_catrgories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_name', 255)->nullable();
            $table->string('en_name', 255)->nullable();
            $table->string('code', 255)->nullable();
            $table->tinyInteger('category_type')->nullable();
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
        Schema::dropIfExists('person_catrgories');
    }
}
