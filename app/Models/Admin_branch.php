<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin_branch extends Model
{
    protected $table = 'admin_branches';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ar_name',
        'en_name',
        'address',
        'code',
        'phone',
        'mobile1',
        'mobile2',
        'email',
        'notes',
        'start_code',
        'end_code',
       
    ];
    public function branch()
    {
        return $this->belongsToMany(User::class,'users_branches','branch_id','user_id');
    }
}
