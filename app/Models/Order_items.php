<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_items extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'ORDER_ITEM_ID';
    protected $fillable = [
      
        'ITEM_ID',
        'BATCH_NO',
        'EXPIRED_DATE',
        'PROPERTY_GRP_ID',
        'ITEM_QTY',
        'ITEM_PRICE',
        'TOTAL_LINE_COST',
        'ORDER_ID',
        'NOTES',
        'ITEM_DISC_PERC',
        'ITEM_DISC_VALUE',
        'FINAL_LINE_COST',
       


    ];
    public function item()
    {
        return $this->belongsTo('App\Models\Item','ITEM_ID');
    }
   
}
