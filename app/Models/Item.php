<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'ITEM_ID';
    protected $fillable = [
      
        'ITEM_CODE',
        'ITEM_AR_NAME',
        'ITEM_EN_NAME',
        'HAS_BATCH',
        'HAS_EXPIRED_DATE',
        'ALLOWED_SERIAL',
        'HAS_BARCODE',
        'ITEM_BARCODE',
        'ITEM_AR_DESCRIPTION',
        'ITEM_EN_DESCRIPTION',
        'STORAGE_UOM_ID',
        'DEFAULT_UOM_ID',
        'MIN_LIMIT',
        'MAX_LIMIT',
        'ITEM_CATEGORY_ID',
        'ITEM_TYPE_ID',
        'ITEM_DIVISION_TYPE_ID',
        'ALLOWED_SALES',

        'AVERAGE_PRICE',
        'WHOLESALE_PRICE',
        'RETAIL_PRICE',

        'PERSON_ID',
        'ALLOW_FREE_SAMPLES',
        'ALLOW_SELLING_COMMISSIONS',

        'ALLOW_DISCOUNTS',
        'LOCAL_SALES_TAX_PERC',
        'EXPORT_SALES_TAX_PERC',

        'GUARANTEE_TAX_PERC',
        'STORAGE_CONDITIONS',
        'ALTERNATE_ITEM_ID',

        'ALTERNATE2_ITEM_ID',
        'NOTES',
        'ITEM_TOTAL_QTY',

        'ITEM_TOTAL_COST',
        'VAT_VALUE',
      
       


    ];
   
}
