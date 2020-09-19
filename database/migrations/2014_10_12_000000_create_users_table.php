<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image',255)->nullable();
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->string('code')->nullable();
            $table->string('ar_full_name', 255)->nullable();
            $table->string('en_full_name', 255)->nullable();
            $table->string('mobile', 255)->nullable();
            $table->string('job', 255)->nullable();
            $table->dateTime('lock_date', 6)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
