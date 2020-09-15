<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice_items extends Model
{
    protected $table = 'INVOICE_ITEM_ID';
    protected $primaryKey = 'INVOICE_ITEM_ID';
    protected $fillable = [
      
        'ITEM_ID',
        'BATCH_NO',
        'EXPIRED_DATE',
        'PROPERTY_GRP_ID',
        'ITEM_QTY',
        'ITEM_PRICE',
        'TOTAL_LINE_COST',
        'INVOICE_ID',


        'ADDITIVE_ITEM_ID',
        'NOTES',

        'ADDITIVE_ITEM_VALUE',
        'TOTAL_LINE_POST_ADD_ITEM',
        'ITEM_DISC_VALUE',

        'ITEM_BONUS_QTY',
        'ITEM_VAT_VALUE',
        'ITEM_VAT_PERC',

        'ITEM_DISC_PERC',
        'FINAL_LINE_COST',
        'REVERTED_ITEM_QTY_TOTAL',
        'REVERTED_ITEM_QTY_BONUS_TOTAL',
       


    ];
    public function item()
    {
        return $this->belongsTo('App\Models\Item','ITEM_ID');
    }
   
}
