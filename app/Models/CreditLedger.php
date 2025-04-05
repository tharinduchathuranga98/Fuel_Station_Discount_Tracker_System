<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_plate',
        'owner_phone',
        'amount',
        'transaction_type',
    ];


}
