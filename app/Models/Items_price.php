<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items_price extends Model
{
    protected $table = 'items_prices';
    protected $primaryKey = 'id';
    protected $fillable = [
        'item_pricing_type_id',
        'item_id',
        'client_category_id',
        'client_id',
        'item_price',

    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Person_catrgory','client_category_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Person','client_id');
    }  

    public function item()
    {
        return $this->belongsTo('App\Models\Item','item_id');
    }

    public function priceType()
    {
        return $this->belongsTo('App\Models\Pric_disc_type','item_pricing_type_id');
    } 
}
