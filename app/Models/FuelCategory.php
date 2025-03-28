<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'fuel_type_code', 'discount_price'];

    // Set primary key to 'code' instead of 'id'
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';


    public static function boot()
    {
        parent::boot();

        static::creating(function ($fuelCategory) {
            // Get the last category ordered by numeric part of 'code'
            $lastCategory = self::where('code', 'LIKE', 'CAT-%')
                ->orderByRaw("CAST(SUBSTRING(code, 5) AS UNSIGNED) DESC")
                ->first();

            $nextNumber = $lastCategory ? ((int)substr($lastCategory->code, 4)) + 1 : 1;

            // Generate code in format: CAT-001, CAT-002, etc.
            $fuelCategory->code = 'CAT-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        });
    }

    // Relationship with FuelType using 'fuel_type_code'
    public function fuelType()
    {
        return $this->belongsTo(FuelType::class, 'fuel_type_code', 'code');
    }
}
