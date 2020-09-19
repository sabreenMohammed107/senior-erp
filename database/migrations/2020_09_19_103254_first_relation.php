<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FirstRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  This is Realations for the cities Table ..
        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('area_id')->references('id')->on('areas');
        });

        //  This is Realations for the locations Table ..
        Schema::table('locations', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities');
        });

        //  This is Realations for the users_modules Table ..
        Schema::table('users_modules', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('modules_categories');
            $table->foreign('module_id')->references('id')->on('modules');

        });


         //  This is Realations for the modules Table ..
         Schema::table('modules', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('modules_categories');
        });


         //  This is Realations for the stock_takings Table ..
         Schema::table('stock_takings', function (Blueprint $table) {
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('stock_taking_status_id')->references('id')->on('stock_taking_statuses');
            $table->foreign('person_id')->references('id')->on('persons');

        });

         //  This is Realations for the stock_taking_items Table ..
         Schema::table('stock_taking_items', function (Blueprint $table) {
            $table->foreign('stock_taking_id')->references('id')->on('stock_takings');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('property_group_id')->references('id')->on('properties_groups');

        });

          //  This is Realations for the users_stocks Table ..
          Schema::table('users_stocks', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('stock_id')->references('id')->on('stocks');
        });

         //  This is Realations for the stocks Table ..
         Schema::table('stocks', function (Blueprint $table) {
            $table->foreign('stock_type_id')->references('id')->on('stock_types');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('gl_item_id')->references('id')->on('glchart_accounts');

        });

          //  This is Realations for the stocks_item_categories Table ..
          Schema::table('stocks_item_categories', function (Blueprint $table) {
            $table->foreign('item_category_id')->references('id')->on('item_categories');
            $table->foreign('stock_id')->references('id')->on('stocks');
        });

        //  This is Realations for the item_categories Table ..
        Schema::table('item_categories', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('item_categories');
        });

         //  This is Realations for the item_property_groups Table ..
         Schema::table('item_property_groups', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('property_group_id')->references('id')->on('properties_groups');
        });

         //  This is Realations for the property_grps_values Table ..
         Schema::table('property_grps_values', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties');
            $table->foreign('property_group_id')->references('id')->on('properties_groups');
            $table->foreign('value_id')->references('id')->on('proeprty_values');

        });

        //  This is Realations for the proeprty_values Table ..
        Schema::table('proeprty_values', function (Blueprint $table) {
            $table->foreign('proeprty_id')->references('id')->on('properties');
        });

          //  This is Realations for the users_branches Table ..
          Schema::table('users_branches', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('branch_id')->references('id')->on('branches');
        });

          //  This is Realations for the user_login_schedules Table ..
          Schema::table('user_login_schedules', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('day_id')->references('id')->on('days');
        });

         //  This is Realations for the representatives Table ..
         Schema::table('representatives', function (Blueprint $table) {
            $table->foreign('rep_type_id')->references('id')->on('rep_types');
        });

         //  This is Realations for the stocks_transaction_types Table ..
         Schema::table('stocks_transaction_types', function (Blueprint $table) {
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types');
            $table->foreign('stock_id')->references('id')->on('stocks');
        });

         //  This is Realations for the stocks_items_totals Table ..
         Schema::table('stocks_items_totals', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('stock_id')->references('id')->on('stocks');
        });


         //  This is Realations for the items Table ..
         Schema::table('items', function (Blueprint $table) {
            $table->foreign('storage_uom_id')->references('id')->on('unit_measures');
            $table->foreign('default_uom_id')->references('id')->on('unit_measures');
            $table->foreign('item_category_id')->references('id')->on('item_categories');
            $table->foreign('item_type_id')->references('id')->on('item_types');
            $table->foreign('item_division_type_id')->references('id')->on('item_devisions');
            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('alternate_item_id')->references('id')->on('items');
            $table->foreign('alternate2_item_id')->references('id')->on('items');
        });

         //  This is Realations for the stocks_transactions Table ..
         Schema::table('stocks_transactions', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types');
            $table->foreign('primary_stock_id')->references('id')->on('stocks');
            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('person_type_id')->references('id')->on('person_types');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('secondary_stock_id')->references('id')->on('stocks');
            $table->foreign('parent_tranaction_id')->references('id')->on('stocks_transactions');
           
        });


         //  This is Realations for the stock_transaction_items Table ..
         Schema::table('stock_transaction_items', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('property_grp_id')->references('id')->on('properties_groups');
            $table->foreign('transaction_id')->references('id')->on('stocks_transactions');

        });

         //  This is Realations for the stock_trans_items_serials Table ..
         Schema::table('stock_trans_items_serials', function (Blueprint $table) {
            $table->foreign('transaction_item_id')->references('id')->on('stock_transaction_items');
       
        });

         //  This is Realations for the unit_measures Table ..
         Schema::table('unit_measures', function (Blueprint $table) {
            $table->foreign('original_unit_measure_id')->references('id')->on('unit_measures');
       
        });

         //  This is Realations for the items_prices Table ..
         Schema::table('items_prices', function (Blueprint $table) {
            $table->foreign('item_pricing_type_id')->references('id')->on('pric_disc_types');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('client_category_id')->references('id')->on('person_catrgories');
            $table->foreign('client_id')->references('id')->on('persons');

        });

         //  This is Realations for the items_discounts Table ..
         Schema::table('items_discounts', function (Blueprint $table) {
            $table->foreign('item_discount_type_id')->references('id')->on('pric_disc_types');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('client_category_id')->references('id')->on('person_catrgories');
            $table->foreign('client_id')->references('id')->on('persons');

        });


         //  This is Realations for the persons Table ..
         Schema::table('persons', function (Blueprint $table) {
            $table->foreign('person_currency_id')->references('id')->on('currencies');
            $table->foreign('person_type_id')->references('id')->on('person_types');
            $table->foreign('person_category_id')->references('id')->on('person_catrgories');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('last_invoice_id')->references('id')->on('invoices');
            $table->foreign('sales_rep_id')->references('id')->on('representatives');
            $table->foreign('marketing_rep_id')->references('id')->on('representatives');
          
           
        });


           //  This is Realations for the person_transactions Table ..
           Schema::table('person_transactions', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('invoice_type_id')->references('id')->on('invoice_types');

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
