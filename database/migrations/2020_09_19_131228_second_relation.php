<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SecondRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  This is Realations for the orders Table ..
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('person_type_id')->references('id')->on('person_types');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('order_status_id')->references('id')->on('order_statuses');
            $table->foreign('order_decision_status_id')->references('id')->on('order_decision_statuses');
            $table->foreign('purchasing_order_type_id')->references('id')->on('purchasing_order_types');
            $table->foreign('sales_rep_id')->references('id')->on('representatives');
            $table->foreign('marketing_rep_id')->references('id')->on('representatives');
        });

        //  This is Realations for the order_items Table ..
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('property_grp_id')->references('id')->on('person_catrgories');
            $table->foreign('order_id')->references('id')->on('orders');
        });


        //  This is Realations for the invoices Table ..
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('invoice_type_id')->references('id')->on('invoice_types');
            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('person_type_id')->references('id')->on('person_types');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('invoice_status_id')->references('id')->on('invoice_statuses');
            $table->foreign('stk_transaction_id')->references('id')->on('stks_business_rules');
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('sales_rep_id')->references('id')->on('representatives');
            $table->foreign('marketing_rep_id')->references('id')->on('representatives');
            $table->foreign('pay_type_id')->references('id')->on('sales_invoice_pay_types');
            $table->foreign('order_id')->references('id')->on('orders');
        });

        //  This is Realations for the invoice_items Table ..
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('property_grp_id')->references('id')->on('person_catrgories');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('additive_item_id')->references('id')->on('inv_additive_items');
        });


        //  This is Realations for the inv_additive_items Table ..
        Schema::table('inv_additive_items', function (Blueprint $table) {
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('additive_item_id')->references('id')->on('additive_items');
        });


        //  This is Realations for the additive_items Table ..
        Schema::table('additive_items', function (Blueprint $table) {
            $table->foreign('gl_item_id')->references('id')->on('glchart_accounts');
        });


         //  This is Realations for the invoice_reverted_items Table ..
         Schema::table('invoice_reverted_items', function (Blueprint $table) {
            $table->foreign('invoice_item_id')->references('id')->on('invoice_items');
            $table->foreign('transaction_id')->references('id')->on('stocks_transactions');
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
