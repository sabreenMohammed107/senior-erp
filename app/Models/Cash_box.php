<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cash_box extends Model
{
    //main settings
    protected $table = 'cash_boxes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'ar_name',
        'en_name',
        'branch_id',
        'open_balance',
        'start_date',
        'current_balance',
        'gl_item_id',
        'notes',
    ];

    //relations
    public function branch()
    {
        return $this->hasOne('App\Models\Branch', 'id','branch_id');
    }

    public function gl_item()
    {
        return $this->hasOne('App\Models\Glchart_account', 'id','gl_item_id');
    }
}
