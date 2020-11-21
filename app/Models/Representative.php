<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    protected $table = 'representatives';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'ar_name',
        'en_name',
        'mobile',
        'rep_nid',
        'rep_type_id',
        'employee_id',
        'branch_id',
    ];
    public function type()
    {
        return $this->belongsTo('App\Models\Rep_type','rep_type_id');
    }
}
