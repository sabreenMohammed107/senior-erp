<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedAssetsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_assets_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('branch_id')->unsigned()->nullable();
            $table->string('code', 255)->nullable();
            $table->string('ar_name', 255)->nullable();
            $table->string('en_name', 255)->nullable();
            $table->BigInteger('category_gl_item_id')->unsigned()->nullable();
            $table->BigInteger('total_deprec_gl_item_id')->unsigned()->nullable();
            $table->BigInteger('asset_deprec_gl_item_id')->unsigned()->nullable();
            $table->float('annual_depreciated_rate',8,2)->nullable();
            $table->dateTime('exclusion_date', 6)->nullable();
            $table->BigInteger('parent_id')->unsigned()->nullable();
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
        Schema::dropIfExists('fixed_assets_categories');
    }
}
