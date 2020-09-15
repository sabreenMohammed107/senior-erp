<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    protected $table = 'stocks';
    protected $primaryKey = 'STOCK_ID';
    protected $fillable = [
        'STOCK_ID',



    ];
    
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
    public function user()
    {
        return $this->belongsToMany(User::class,'users_stocks','STOCK_ID','USER_ID');
    }
}
