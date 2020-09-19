<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_name', 255)->nullable();
            $table->string('en_name', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('mobile1', 255)->nullable();
            $table->string('mobile2', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('logo_path', 255)->nullable();
            $table->string('chairman', 255)->nullable();
            $table->string('tax_no', 255)->nullable();
            $table->string('cammercial_card', 255)->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
