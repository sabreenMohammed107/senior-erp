<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $fillable = [
        'invoice_type_id',
        'invoice_date',
        'invoice_no',
        'invoice_serial',
        'person_id',
        'person_name',
        'person_type_id',
        'purch_invoice_reference',
        'currency_id',
        'invoice_status_id',
        'total_items_price',
        'local_net_invoice',
        'exchange_rate',
        'foreign_net_invoice',
        'confirmed',
        'notes',
        'stk_transaction_id',
        'stock_id',
        'total_invoice_additive',
        'branch_id',
        'total_disc_value',
        'total_bonus_qty',
        'total_vat_value',
        'sales_rep_id',
        'marketing_rep_id',
        'pay_type_id',
        'print_sales_cnt',
        'order_id',
    ];

    public function item()
    {
        return $this->hasMany('App\Models\Invoice_item','invoice_id','id');
    }
    public function additive()
    {
        return $this->belongsToMany('App\Models\Additive_item','inv_additive_items','additive_item_id','invoice_id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Models\Stocks_transaction','stk_transaction_id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch','branch_id');
    }
    public function person()
    {
        return $this->belongsTo('App\Models\Person','person_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Orders','order_id');
    }
}
