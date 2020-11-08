<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stocks_transaction extends Model
{
    protected $table = 'stocks_transactions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'transaction_date',
        'referance_type',
        'order_id',
        'transaction_type_id',
        'primary_stock_id',
        'person_id',
        'person_name',
        'person_type_id',
        'invoice_id',
        'permission_code',
        'permission_date',
        'secondary_stock_id',
        'confirmed',
        'notes',
        'drive_id',
        'car_no',
        'rcvd_confirmed',
        'parent_tranaction_id',
        'total_items_price',
        'local_net_invoice',
        'foreign_net_invoice',
        'total_disc_value',
        'total_bonus_qty',
        'total_vat_value',
    ];

     //relation
     public function transaction()
     {
         return $this->belongsTo('App\Models\Stock','primary_stock_id');
     }
     public function secondry()
     {
         return $this->belongsTo('App\Models\Stock','secondary_stock_id');
     }

      //relation
      public function person()
      {
          return $this->belongsTo('App\Models\Person','person_id');
      }
      public function item()
      {
          return $this->hasMany('App\Models\Stock_transaction_item','transaction_id','id');
      }
      public function type()
     {
         return $this->hasOne('App\Models\Transaction_type','id','transaction_type_id');
     }


      public function invoice()
      {
          return $this->belongsTo('App\Models\Invoice','invoice_id');
      }
}
