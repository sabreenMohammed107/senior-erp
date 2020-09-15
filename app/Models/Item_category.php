<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_category extends Model
{
    protected $table = 'item_categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ar_name',
        'en_name',
        'parent_id',
        'code',
        'ar_description',
        'en_description',
       
       
    ];

    //relation
    public function child()
    {
        return $this->belongsTo('App\Models\Item_category','parent_id');
    }

    //relation 
    public function parent()
    {
        return $this->hasMany('App\Models\Item_category','parent_id','id');
    }
}
