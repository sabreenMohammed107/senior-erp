<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'persons';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
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
}
