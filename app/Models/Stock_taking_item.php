<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock_taking_item extends Model
{
    protected $table = 'stock_taking_items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'stock_taking_id',
        'item_id',
        'batch_no',
        'expired_date',
        'property_group_id',
        'system_qty',
        'physical_qty',
        'additive_qty',
        'additive_cost',
        'subtractive_qty',
        'subtractive_cost',
        'settlement_done',
    ];
    public function item()
    {
        return $this->belongsTo('App\Models\Item','item_id');
    }
    public function taking()
    {
        return $this->belongsTo('App\Models\Stock_taking','stock_taking_id');
    }
}
