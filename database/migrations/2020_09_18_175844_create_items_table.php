<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('ar_name', 255)->nullable();
            $table->string('en_name', 255)->nullable();
            $table->tinyInteger('has_batch')->nullable();
           
            $table->tinyInteger('has_expired_date')->nullable();
            $table->dateTime('generated_end_date', 6)->nullable();
            $table->tinyInteger('allowed_serial')->nullable();
            $table->tinyInteger('has_barcode')->nullable();
            $table->string('item_barcode', 255)->nullable();
            $table->text('ar_description')->nullable();
            $table->text('en_description')->nullable();
            $table->BigInteger('storage_uom_id')->unsigned()->nullable();
            $table->BigInteger('default_uom_id')->unsigned()->nullable();
            $table->integer('min_limit')->nullable();
            $table->integer('max_limit')->nullable();
            $table->integer('request_limit')->nullable();
            $table->BigInteger('item_category_id')->unsigned()->nullable();
            $table->BigInteger('item_type_id')->unsigned()->nullable();
            $table->BigInteger('item_division_type_id')->unsigned()->nullable();
            $table->tinyInteger('allowed_sale')->nullable();
            $table->float('average_price',8,2)->nullable();
            $table->float('wholesale_price',8,2)->nullable();
            $table->float('retail_price',8,2)->nullable();
            $table->BigInteger('person_id')->unsigned()->nullable();
            $table->tinyInteger('allow_free_sale')->nullable();
            $table->tinyInteger('allow_sale_commission')->nullable();
            $table->tinyInteger('allowe_discount')->nullable();
            $table->integer('local_sale_tax_price')->nullable();
            $table->integer('export_sale_tax_prec')->nullable();
            $table->integer('guarantee_tax_prec')->nullable();
            $table->text('storage_condation')->nullable();
            $table->BigInteger('alternate_item_id')->unsigned()->nullable();
            $table->BigInteger('alternate2_item_id')->unsigned()->nullable();
            $table->text('notes')->nullable();
            $table->float('item_total_cost',8,2)->nullable();
            $table->integer('item_total_qty')->nullable();
            $table->float('vat_value',8,2)->nullable();

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
        Schema::dropIfExists('items');
    }
}
