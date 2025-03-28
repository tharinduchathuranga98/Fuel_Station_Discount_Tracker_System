<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'code'];

    // Set primary key to 'code' instead of 'id'
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($fuelType) {
            // Get the last fuel type ordered by code numerically
            $lastFuelType = self::where('code', 'LIKE', 'FUEL-%')
                                ->orderByRaw("CAST(SUBSTRING(code, 6) AS UNSIGNED) DESC")
                                ->first();

            $nextNumber = $lastFuelType ? ((int)substr($lastFuelType->code, 5)) + 1 : 1;

            // Generate code in format: FUEL-001, FUEL-002, etc.
            $fuelType->code = 'FUEL-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        });
    }
}
