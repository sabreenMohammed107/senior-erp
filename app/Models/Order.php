<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'purch_order_no',
        'order_serial',
        'order_type_id',
        'order_date',
        'branch_id',
        'person_id',
        'stock_id',
        'person_name',
        'person_type_id',
        'received_date_suggested',
        'currency_id',
        'exchange_rate',
        'order_description',
        'order_status_id',
        'order_decision_status_id',
        'order_value',
        'purchasing_order_type_id',
        'confirmed',
        'confirmed_emp_id',
        'notes',
        'total_disc_value',
        'total_final_cost',
        'sales_rep_id',
        'marketing_rep_id',
    ];
    public function item()
    {
        return $this->hasMany('App\Models\Order_item','order_id','id');
    }

}
