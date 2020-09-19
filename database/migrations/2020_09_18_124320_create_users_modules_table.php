<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('user_id')->unsigned()->nullable();
            $table->BigInteger('category_id')->unsigned()->nullable();
            $table->BigInteger('module_id')->unsigned()->nullable();
            $table->tinyInteger('query_allowed')->nullable();
            $table->tinyInteger('insert_allowed')->nullable();
            $table->tinyInteger('update_allowed')->nullable();
            $table->tinyInteger('delete_allowed')->nullable();

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
        Schema::dropIfExists('users_modules');
    }
}
