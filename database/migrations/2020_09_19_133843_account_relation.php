<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccountRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //   This is Realations for the fixed_assets_categories Table ...

        Schema::table('fixed_assets_categories', function (Blueprint $table) {
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('category_gl_item_id')->references('id')->on('glchart_accounts');
            $table->foreign('total_deprec_gl_item_id')->references('id')->on('glchart_accounts');
            $table->foreign('asset_deprec_gl_item_id')->references('id')->on('glchart_accounts');
            $table->foreign('parent_id')->references('id')->on('fixed_assets_categories');
        });

        //   This is Realations for the asset_sales Table ...
        Schema::table('asset_sales', function (Blueprint $table) {
            $table->foreign('fixed_asset_id')->references('id')->on('fixed_assets');
            $table->foreign('client_id')->references('id')->on('persons');
            $table->foreign('cheuqe_id')->references('id')->on('cheques');
            $table->foreign('cash_box_id')->references('id')->on('cash_boxes');
        });

        //   This is Realations for the asset_historical_moves Table ...
        Schema::table('asset_historical_moves', function (Blueprint $table) {
            $table->foreign('fixed_asset_id')->references('id')->on('fixed_assets');
            $table->foreign('barnch_from_id')->references('id')->on('branches');
            $table->foreign('branch_to_id')->references('id')->on('branches');
        });

        //   This is Realations for the banks Table ...
        Schema::table('banks', function (Blueprint $table) {
            $table->foreign('gl_item_id')->references('id')->on('glchart_accounts');
        });

        //   This is Realations for the cheques Table ...
        Schema::table('cheques', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('cheque_type_id')->references('id')->on('cheuqe_types');
        });


        //   This is Realations for the financial_entries Table ...
        Schema::table('financial_entries', function (Blueprint $table) {
            $table->foreign('trans_type_id')->references('id')->on('finan_transaction_types');
            $table->foreign('gl_item_id')->references('id')->on('glchart_accounts');
            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('cash_box_id')->references('id')->on('cash_boxes');
            $table->foreign('cheque_id')->references('id')->on('cheques');
            $table->foreign('voucher_id')->references('id')->on('vouchers');
            $table->foreign('stock_id')->references('id')->on('stocks');
        });


        //   This is Realations for the fixed_assets Table ...
        Schema::table('fixed_assets', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('fixed_assets_categories');
            $table->foreign('status_id')->references('id')->on('fixed_asset_statuses');
            $table->foreign('supplier_id')->references('id')->on('persons');
            $table->foreign('client_id')->references('id')->on('persons');
        });

        //   This is Realations for the assets_exclusions Table ...
        Schema::table('assets_exclusions', function (Blueprint $table) {
            $table->foreign('asset_id')->references('id')->on('fixed_assets');
            $table->foreign('exclusion_type_id')->references('id')->on('assets_exclusion_types');
        });

        //   This is Realations for the assets_additions Table ...
        Schema::table('assets_additions', function (Blueprint $table) {

            $table->foreign('supplier_id')->references('id')->on('persons');
        });

        //   This is Realations for the cash_boxes Table ...
        Schema::table('cash_boxes', function (Blueprint $table) {
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('gl_item_id')->references('id')->on('glchart_accounts');
        });

        //   This is Realations for the vouchers Table ...
        Schema::table('vouchers', function (Blueprint $table) {
            $table->foreign('voucher_type_id')->references('id')->on('voucher_types');
            $table->foreign('voucher_ref_type_id')->references('id')->on('voucher_items');
            $table->foreign('cash_box_id')->references('id')->on('cash_boxes');
            $table->foreign('cheque_id')->references('id')->on('cheques');
        });

        //   This is Realations for the voucher_items Table ...
        Schema::table('voucher_items', function (Blueprint $table) {
            $table->foreign('voucher_id')->references('id')->on('vouchers');
            $table->foreign('item_type_ref_id')->references('id')->on('reference_types');
            $table->foreign('gl_item_id')->references('id')->on('glchart_accounts');
            $table->foreign('person_id')->references('id')->on('persons');
        });

        //   This is Realations for the financial_subsystems Table ...
        Schema::table('financial_subsystems', function (Blueprint $table) {
            $table->foreign('gl_item_id')->references('id')->on('glchart_accounts');
        });


        //   This is Realations for the financial_subsystems Table ...
        Schema::table('glchart_accounts', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('glchart_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
