<?php


namespace App\Http\Controllers;

use App\Models\RefuelingRecord;
use App\Models\Vehicle;
use App\Models\FuelCategory;
use App\Models\FuelType;
use Illuminate\Http\Request;
use App\Helpers\SmsHelper;

class RefuelingController extends Controller
{
    public function recordRefueling(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'number_plate' => 'required|string',
            'liters' => 'required|numeric|min:1',
        ]);

        // Find the vehicle by number plate
        $vehicle = Vehicle::where('number_plate', $validated['number_plate'])->first();

        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        // Find the fuel category of the vehicle
        $fuelCategory = FuelCategory::where('code', $vehicle->category)->first();

        if (!$fuelCategory) {
            return response()->json(['error' => 'Fuel category not found'], 404);
        }

        // Find the fuel type associated with the category
        $fuelType = FuelType::where('code', $fuelCategory->fuel_type_code)->first();

        if (!$fuelType) {
            return response()->json(['error' => 'Fuel type not found'], 404);
        }

        // Calculate total price
        $discountPrice = $fuelCategory->discount_price;
        $fuelPrice = $fuelType->price;
        $totalPrice = ($fuelPrice - $discountPrice) * $validated['liters'];

        // Create the refueling record
        $refuelingRecord = RefuelingRecord::create([
            'number_plate' => $validated['number_plate'],
            'liters' => $validated['liters'],
            'total_price' => $totalPrice,
            'refueled_at' => now(),
        ]);

        // Send SMS to the vehicle owner
        $message = "Your vehicle has been refueled with {$validated['liters']} liters for Rs: {$totalPrice}. Number Plate: {$vehicle->number_plate}";
        SmsHelper::sendSms($vehicle->owner_phone, $message);

        return response()->json([
            'message' => 'Refueling record added successfully',
            'data' => $refuelingRecord,
        ], 201);
    }
}

