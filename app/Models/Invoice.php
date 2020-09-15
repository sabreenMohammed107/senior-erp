<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'INVOICE_ID';
    protected $fillable = [
       
        'INVOICE_TYPE_ID',
        'INVOICE_DATE',
        'INVOICE_NO',
        'INVOICE_SERIAL',
        'PERSON_ID',
        'STOCK_ID',
        'PERSON_NAME',
        'PERSON_TYPE_ID',
        'PURCH_INVOICE_REFERENCE',
        'CURRENCY_ID',
        'INVOICE_STATUS_ID',
        'TOTAL_ITEMS_PRICE',
        'LOCAL_NET_INVOICE',
        'EXCHANGE_RATE',
        'FOREIGN_NET_INVOICE',
        'CONFIRMED',
        'NOTES',
        'STK_TRANSACTION_ID',
        'STOCK_ID',
        'branch_id',
        'TOTAL_INVOICE_ADDITIVE',
        'TOTAL_DISC_VALUE',
        'TOTAL_BONUS_QTY',
        'TOTAL_VAT_VALUE',


        'SALES_REP_ID',
        'MARKETING_REP_ID',
        'PAY_TYPE_ID',
        'PRINT_SALES_CNT',
        'ORDER_ID',


    ];
    
    public function stock()
    {
        return $this->belongsTo('App\Models\Stocks','STOCK_ID');
    }
    public function branch()
    {
        return $this->belongsTo('App\Models\Admin_branch','branch_id');
    }

    public function person()
    {
        return $this->belongsTo('App\Models\Person','PERSON_ID');
    }
}
