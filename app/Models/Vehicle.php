<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['number_plate', 'owner_name', 'company_name', 'owner_phone', 'fuel_type', 'category', 'qr_code', 'status'];

    // Always load relationships
    protected $with = ['fuelType', 'category'];

    // Define relationship using `code` instead of `id`
    public function fuelType()
    {
        return $this->belongsTo(FuelType::class, 'fuel_type', 'code'); // `fuel_type` in vehicles references `code` in fuel_types
    }

    public function category()
    {
        return $this->belongsTo(FuelCategory::class, 'category', 'code');
    }
}
