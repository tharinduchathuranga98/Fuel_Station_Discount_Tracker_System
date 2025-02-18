<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelCategory extends Model
{
    protected $fillable = ['name', 'code',  'fuel_type_code', 'discount_price'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($fuelCategory) {
            $lastCategory = self::latest()->first();
            $nextNumber = $lastCategory ? ((int)substr($lastCategory->code, 4)) + 1 : 1;
            $fuelCategory->code = 'CAT-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        });
    }

    public function fuelType()
    {
        return $this->belongsTo(FuelType::class, 'fuel_type_code', 'code');
    }



}

