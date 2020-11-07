<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id';
    protected $fillable = [
     
        'code','ar_name','en_name','has_batch','image',
        'has_expired_date','generated_end_date', 'allowed_serial','has_barcode',
        'item_barcode','ar_description','en_description','storage_uom_id','default_uom_id',
        'min_limit','max_limit','request_limit','item_category_id','item_type_id',
        'item_division_type_id','allowed_sale','average_price','wholesale_price',
        'retail_price','person_id','allow_free_sale','allow_sale_commission',
        'allowe_discount','local_sale_tax_price','export_sale_tax_prec','guarantee_tax_prec',
        'storage_condation','alternate_item_id','alternate2_item_id','notes','item_total_cost',
        'item_total_qty','vat_value'

    ];

     //relation
     public function category()
     {
         return $this->belongsTo('App\Models\Item_category','item_category_id');
     }
     public function person()
     {
         return $this->belongsTo('App\Models\Person','person_id');
     }
     public function type()
     {
         return $this->belongsTo('App\Models\Item_type','item_type_id');
     }

     public function uom()
     {
         return $this->belongsTo('App\Models\Unit_measure','default_uom_id');
     }
}
