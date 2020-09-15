<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'ORDER_ID';
    protected $fillable = [
        'ORDER_ID',
        'PURCH_ORDER_NO',
        'ORDER_SERIAL',
        'ORDER_TYPE_ID',
        'ORDER_DATE',
        'PERSON_ID',
        'STOCK_ID',
        'PERSON_NAME',
        'PERSON_TYPE_ID',
        'RECEIVED_DATE_SUGGESTED',
        'CURRENCY_ID',
        'EXCHANGE_RATE',
        'ORDER_DESCRIPTION',
        'ORDER_STATUS_ID',
        'ORDER_VALUE',
        'PURCHASING_ORDER_TYPE_ID',
        'CONFIRMED',
        'CONFIRMED_EMP_ID',
        'NOTES',
        'ORDER_DECISION_STATUS_ID',
        'TOTAL_DISC_VALUE',
        'TOTAL_FINAL_COST',
        'SALES_REP_ID',
        'MARKETING_REP_ID',


    ];
    
    public function stock()
    {
        return $this->belongsTo('App\Models\Stocks','STOCK_ID');
    }

    public function person()
    {
        return $this->belongsTo('App\Models\Person','PERSON_ID');
    }
}
