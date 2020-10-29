<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock_taking extends Model
{
    protected $table = 'stock_takings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'taking_date',
        'taking_no',
        'stock_id',
        'stock_taking_status_id',
        'person_id',
        'responsible_emp_id',
        'responsible_emp2_id',
        'responsible_emp3_id',

    ];
    public function status()
    {
        return $this->belongsTo('App\Models\Stock_taking_status','stock_taking_status_id');
    }
}
