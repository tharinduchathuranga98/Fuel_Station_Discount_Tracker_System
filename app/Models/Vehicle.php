<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['number_plate', 'owner_name', 'owner_phone', 'qr_code', 'fuel_type', 'category'];
    public function category()
    {
        return $this->belongsTo(FuelCategory::class, 'category', 'code'); // 'category' should be the foreign key referring to FuelCategory
    }

    public function fuelType()
    {
        return $this->belongsTo(FuelType::class, 'fuel_type', 'code'); // 'fuel_type' should be the foreign key referring to FuelType
    }
}
