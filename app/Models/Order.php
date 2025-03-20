<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'title',
        'price',
        'quantity',
        'image',
        'delivery_status',
        'payment_date',
        'payment_amount'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'payment_amount' => 'decimal:2'
    ];
}
