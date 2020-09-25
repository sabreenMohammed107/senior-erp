<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('nick_name', 255)->nullable();
            $table->string('phone1', 255)->nullable();
            $table->string('phone2', 255)->nullable();
            $table->string('fax', 255)->nullable();
            $table->string('contact_person', 255)->nullable();
            $table->string('contact_person_mobile', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('commercial_register', 255)->nullable();
            $table->string('tax_card', 255)->nullable();
            $table->string('tax_authority', 255)->nullable();
            $table->BigInteger('person_currency_id')->unsigned()->nullable();
            $table->BigInteger('person_type_id')->unsigned()->nullable();
            $table->float('person_open_balance', 8, 2)->nullable();
            $table->dateTime('person_open_balance_date', 6)->nullable();
            $table->float('person_current_balance', 8, 2)->nullable();
            $table->float('person_limit_balance', 8, 2)->nullable();
            $table->text('notes')->nullable();
            $table->BigInteger('person_category_id')->unsigned()->nullable();
            $table->BigInteger('branch_id')->unsigned()->nullable();
            $table->BigInteger('country_id')->unsigned()->nullable();
            $table->BigInteger('city_id')->unsigned()->nullable();
            $table->BigInteger('location_id')->unsigned()->nullable();
            $table->BigInteger('last_invoice_id')->unsigned()->nullable();
            $table->BigInteger('department_id')->unsigned()->nullable();
            $table->BigInteger('sales_rep_id')->unsigned()->nullable();
            $table->BigInteger('marketing_rep_id')->unsigned()->nullable();
            $table->tinyInteger('balance_type')->nullable();
            $table->dateTime('last_invoice_date', 6)->nullable();

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
        Schema::dropIfExists('persons');
    }
}
