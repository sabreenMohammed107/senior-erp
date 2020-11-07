<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock_transaction_item extends Model
{
    protected $table = 'stock_transaction_items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'item_id',
        'batch_no',
        'expired_date',
        'property_grp_id',
        'item_qty',
        'item_price',
        'total_line_cost',
        'transaction_id',
        'notes',
        'item_disc_value',
        'item_bonus_qty',
        'item_vat_value',
        'item_vat_perc',
        'item_disc_perc',
        'final_line_cost',

    ];

     //relation
     public function transaction()
     {
         return $this->belongsTo('App\Models\Stocks_transaction','transaction_id');
     }

     public function item()
     {
         return $this->belongsTo('App\Models\Item','item_id');
     }


}
