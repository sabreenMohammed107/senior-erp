<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Glchart_account extends Model
{
    //main settings
    protected $table = 'glchart_accounts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'ar_name',
        'en_name',
        'gl_item_level',
        'parent_id',
        'system_item',
        'open_balance',
        'balance_start_date',
        'current_balance',
        'balance_type',
    ];
}
