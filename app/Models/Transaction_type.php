<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction_type extends Model
{
    protected $table = 'transaction_types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
      
    ];
    public function type()
     {
         return $this->belongsTo('App\Models\Transaction_type','transaction_type_id');
     }

}
