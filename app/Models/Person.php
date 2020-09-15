<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'persons';
    protected $primaryKey = 'PERSON_ID';
    protected $fillable = [
        'PERSON_CODE',
        'PERSON_NAME',
        'PERSON_NICK_NAME',
        'PERSON_PHONE1',
        'PERSON_PHONE2',
        'PERSON_FAX',
        'CONTACT_PERSON',
        'CONTACT_PERSON_MOBILE',
        'PERSON_WEBSITE',
        'PERSON_EMAIL',
        'COMMERCIAL_REGISTER',

        'TAX_CARD',
        'TAX_AUTHORITY',
        'PERSON_CURRENCY_ID',
        'PERSON_TYPE_ID',
        'PERSON_OPEN_BALANCE',
        'PERSON_OPEN_BALANCE_DATE',
        'PERSON_CURRENT_BALANCE',
        'PERSON_LIMIT_BALANCE',
        'NOTES',
        'PERSON_CATEGORY_ID',
        'id',


        'COUNTRY_ID',
        'CITY_ID',
        'LOCATION_ID',
        'LAST_INVOICE_ID',
        'LAST_INVOICE_DATE',
        'SALES_REP_ID',
        'MARKETING_REP_ID',
        'BALANCE_TYPE',
        'DEPARTMENT_ID',
        
       
    ];
    public function branch()
    {
        return $this->belongsToMany(User::class,'users_branches','branch_id','user_id');
    }
}
