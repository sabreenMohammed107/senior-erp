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
}
