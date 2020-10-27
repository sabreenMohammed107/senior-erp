<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'code', 'image', 'job',
        'ar_full_name', 'en_full_name', 'mobile',
        'lock_date', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function branch()
    {
        return $this->belongsToMany(Models\Branch::class,'users_branches','user_id','branch_id');
    }
    public function stock()
    {
        return $this->belongsToMany(Models\Stock::class,'users_stocks','user_id','stock_id');
    }
}
