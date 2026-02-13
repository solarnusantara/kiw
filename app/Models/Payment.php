<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory; 

    protected $fillable = [
        'user_id',
		'order_id',
        'external_id',
        'amount',
        'payer_email',
        'description',
        'checkout_link',
    ];
}
