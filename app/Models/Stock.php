<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'ar_name',
        'en_name',
        'is_main_stock',
        'stock_type_id',
        'branch_id',
        'responsible_emp_id',
        'stock_taking_emp_id',
        'stock_taking_last_date',
        'has_open_balance',
        'open_balance_date',
        'apply_all_grp_category',
        'apply_all_stk_operations',
        'gl_item_id',
        'notes',
        'created_at',
        'updated_at'
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
    public function category()
    {
        return $this->belongsToMany(Item_category::class,'stocks_item_categories','stock_id','item_category_id');
    }

    public function type()
    {
        return $this->belongsToMany(Transaction_type::class,'stocks_transaction_types','stock_id','transaction_type_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch','branch_id');
    }
}
