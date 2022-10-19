<?php

namespace App\Models\Future;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable = [
        'user_id', 'name_customer', 'cccd_customer', 'phone_customer', 'address_customer', 'gender_customer', 'product_id', 'created_at'
    ];

    public $timestamps = true;
}
