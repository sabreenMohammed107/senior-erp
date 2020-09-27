<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items_discount extends Model
{
    protected $table = 'items_discounts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'item_discount_type_id',
        'item_id',
        'client_category_id',
        'client_id',
        'item_discount_price',
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
        return $this->belongsTo('App\Models\Pric_disc_type','item_discount_type_id');
    } 
}
