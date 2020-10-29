<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stocks_items_total extends Model
{
    protected $table = 'stocks_items_totals';
    protected $primaryKey = 'id';
    protected $fillable = [
        'stock_id',
        'item_id',
        'batch_no',
        'expired_date',
        'item_total_qty',
        'item_qty_unconfirmed',
        'notes',
        'created_at',
        'updated_at'
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Item','item_id');
    }
   
}
