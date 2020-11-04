<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users_branch extends Model
{
    protected $table = 'users_branches';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
      'branch_id',
    ];
}
