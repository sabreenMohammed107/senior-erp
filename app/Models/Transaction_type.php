<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction_type extends Model
{
    protected $table = 'finan_transaction_types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
      
    ];

}
