<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Financial_entry extends Model
{
    protected $table = 'financial_entries';
    protected $primaryKey = 'id';
    protected $fillable = [
        'trans_type_id',
        'entry_serial',
        'entry_date',
        'gl_item_id',
        'debit',
        'credit',
        'person_id',
        'person_name',
        'cash_box_id',
        'cheque_id',
        'voucher_id',
        'stock_id',
        'entry_statment',
        'branch_id',
        'bank_id',
    ];
    
}
