<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stocks_transaction_type extends Model
{
    protected $table = 'stocks_transaction_types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'transaction_type_id',
        'stock_id',
        'notes',
      
    ];
}
