<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedVirtualAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'bank_code',
        'name',
        'is_single_use',
        'expected_amount',
        'account_number',
        'status',
    ];
}
