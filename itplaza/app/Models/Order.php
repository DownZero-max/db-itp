<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'date',
        'date_completed',
        'name',
        'phone_number',
        'payment',
        'transfer',
        'check',
        'wrong',
        'verified',
        'incomplete',
        'performer',
        'delivery',
        'address',
        'about_delivery'
    ];
}
