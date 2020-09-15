<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_branches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ar_name', 250)->nullable();
            $table->string('en_name', 250)->nullable();
            $table->string('address', 1000)->nullable();
            $table->integer('code')->default(0);
            $table->string('phone', 250)->nullable();
            $table->string('mobile1', 250)->nullable();
            $table->string('mobile2', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->text('notes')->nullable();
            $table->integer('start_code')->default(0);
            $table->integer('end_code')->default(0);
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
        Schema::dropIfExists('admin_branches');
    }
}
