<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $fillable = [
    'item_id',
    'batch_no',
    'expired_date',
    'property_grp_id',
    'item_qty',
    'item_price',
    'total_line_cost',
    'order_id',
    'notes',
    'item_disc_perc',
    'item_disc_value',
    'final_line_cost',
];
public function item()
    {
        return $this->belongsTo('App\Models\Item','item_id');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id');
    }
}
