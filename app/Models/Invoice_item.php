<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice_item extends Model
{
    protected $table = 'invoice_items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'item_id',
        'batch_no',
        'expired_date',
        'property_grp_id',
        'item_qty',
        'item_price',
        'total_line_cost',
        'invoice_id',
        'additive_item_id',
        'notes',
        'additive_item_value',
        'total_line_post_add_item',
        'item_disc_value',
        'item_bonus_qty',
        'item_vat_value',
        'item_vat_perc',
        'item_disc_perc',
        'final_line_cost',
        'reverted_item_qty_total',
        'reverted_item_qty_bonus_total',
    ];
}
