<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'persons';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'image',
        'name',
        'nick_name',
        'phone1',
        'phone2',
        'fax',
        'contact_person',
        'contact_person_mobile',
        'website',
        'email',
        'commercial_register',
        'tax_card',
        'tax_authority',
        'person_currency_id',
        'person_type_id',
        'person_open_balance',
        'person_open_balance_date',
        'person_current_balance',
        'person_limit_balance',
        'notes',
        'person_category_id',
        'branch_id',
        'country_id',
        'city_id',
        'location_id',
        'last_invoice_id',
        'department_id',
        'sales_rep_id',
        'marketing_rep_id',
        'balance_type',
        'last_invoice_date',
        'created_at',
        'updated_at'

    ];


    public function country()
    {
        return $this->belongsTo('App\Models\Country','country_id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City','city_id');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Location','location_id');
    }

    public function sale()
    {
        return $this->belongsTo('App\Models\Representative','sales_rep_id');
    }

    public function market()
    {
        return $this->belongsTo('App\Models\Representative','marketing_rep_id');
    }
}
