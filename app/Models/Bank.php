<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    //main settings
    protected $table = 'banks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'ar_name',
        'en_name',
        'branch_address',
        'branch_phone',
        'branch_fax',
        'open_balance',
        'balance_start_date',
        'current_balance',
        'gl_item_id',
        'notes',
    ];
}
