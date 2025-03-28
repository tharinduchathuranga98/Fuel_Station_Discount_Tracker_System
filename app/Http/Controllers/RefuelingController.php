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
        $total_discount = round($discountPrice * $validated['liters'], 2);
        $fuelPrice = $fuelType->price;
        $totalPrice = round(($fuelPrice - $discountPrice) * $validated['liters'], 2);;
        $formattedTotalPrice = number_format($totalPrice, 2, '.', '');
        $formattedTotalDiscount = number_format($total_discount, 2, '.', '');

        // Create the refueling record
        $refuelingRecord = RefuelingRecord::create([
            'number_plate' => $validated['number_plate'],
            'liters' => $validated['liters'],
            'fuel_type' => $fuelCategory->fuel_type_code,
            'total_price' => $totalPrice,
            'total_discount' => $total_discount, // Save discount
            'refueled_at' => now(),
        ]);

        // Send SMS to the vehicle owner
        $message = "Your vehicle has been refueled with {$validated['liters']} liters for Rs: {$formattedTotalPrice}. You got a discount of Rs: {$formattedTotalDiscount}. Number Plate: {$vehicle->number_plate}";
        SmsHelper::sendSms($vehicle->owner_phone, $message);

        return response()->json([
            'message' => 'Refueling record added successfully',
            'data' => $refuelingRecord,
        ], 201);
    }

    public function dailyReport(Request $request)
    {
        // Get today's date
        $today = now()->startOfDay();  // Start of today
        $formattedDate = now()->format('Y-m-d'); // Format the date as YYYY-MM-DD

        // Fetch refueling records for today
        $refuelingRecords = RefuelingRecord::where('refueled_at', '>=', $today)
            ->where('refueled_at', '<=', now())
            ->get();

        // Group the records by fuel_type
        $groupedByFuelType = $refuelingRecords->groupBy('fuel_type');

        // Initialize variables to store totals
        $totalSales = 0;
        $totalLiters = 0;
        $totalDiscount = 0;

        $fuelTypeSales = [];

        // Loop through each group (fuel type) and calculate total liters, sales, and discount
        foreach ($groupedByFuelType as $fuelTypeCode => $records) {
            // Fetch the fuel type name from the FuelType model using the code
            $fuelType = FuelType::where('code', $fuelTypeCode)->first();

            // Get the fuel type name, default to 'Unknown' if not found
            $fuelTypeName = $fuelType ? $fuelType->name : 'Unknown';

            $totalLitersForType = $records->sum('liters');
            $totalSalesForType = $records->sum('total_price');
            $totalDiscountForType = $records->sum('total_discount');

            // Add to the overall totals
            $totalSales += $totalSalesForType;
            $totalLiters += $totalLitersForType;
            $totalDiscount += $totalDiscountForType;

            // Format the values and store in the result array
            $fuelTypeSales[] = [
                'fuel_type' => $fuelTypeName,  // Use the fuel type name
                'total_liters' => number_format($totalLitersForType, 2, '.', ''),
                'total_sales' => number_format($totalSalesForType, 2, '.', ''),
                'total_discount' => number_format($totalDiscountForType, 2, '.', ''),
            ];
        }

        // Format the overall totals
        $formattedTotalSales = number_format($totalSales, 2, '.', '');
        $formattedTotalDiscount = number_format($totalDiscount, 2, '.', '');

        // Prepare response data
        $report = [
            'date' => $formattedDate,  // Include date in the response
            'fuel_types' => $fuelTypeSales,  // Sales for each fuel type
            'total_sales' => $formattedTotalSales,
            'total_liters' => number_format($totalLiters, 2, '.', ''),
            'total_discount' => $formattedTotalDiscount,
        ];

        return response()->json([
            'message' => 'Daily report generated successfully',
            'report' => $report
        ], 200);
    }

    public function monthlyReport(Request $request)
    {
        // Get the start of the current month (first day of the month)
        $startOfMonth = now()->startOfMonth();  // Start of the current month
        $endOfMonth = now()->endOfMonth();      // End of the current month

        // Fetch refueling records for the current month
        $refuelingRecords = RefuelingRecord::where('refueled_at', '>=', $startOfMonth)
            ->where('refueled_at', '<=', $endOfMonth)
            ->get();

        // Group the records by fuel_type
        $groupedByFuelType = $refuelingRecords->groupBy('fuel_type');

        // Initialize variables to store totals
        $totalSales = 0;
        $totalLiters = 0;
        $totalDiscount = 0;

        $fuelTypeSales = [];

        // Loop through each group (fuel type) and calculate total liters, sales, and discount
        foreach ($groupedByFuelType as $fuelTypeCode => $records) {
            // Fetch the fuel type name from the FuelType model using the code
            $fuelType = FuelType::where('code', $fuelTypeCode)->first();

            // Get the fuel type name, default to 'Unknown' if not found
            $fuelTypeName = $fuelType ? $fuelType->name : 'Unknown';

            $totalLitersForType = $records->sum('liters');
            $totalSalesForType = $records->sum('total_price');
            $totalDiscountForType = $records->sum('total_discount');

            // Add to the overall totals
            $totalSales += $totalSalesForType;
            $totalLiters += $totalLitersForType;
            $totalDiscount += $totalDiscountForType;

            // Format the values and store in the result array
            $fuelTypeSales[] = [
                'fuel_type' => $fuelTypeName,  // Use the fuel type name
                'total_liters' => number_format($totalLitersForType, 2, '.', ''),
                'total_sales' => number_format($totalSalesForType, 2, '.', ''),
                'total_discount' => number_format($totalDiscountForType, 2, '.', ''),
            ];
        }

        // Format the overall totals
        $formattedTotalSales = number_format($totalSales, 2, '.', '');
        $formattedTotalDiscount = number_format($totalDiscount, 2, '.', '');

        // Prepare response data
        $report = [
            'month' => now()->format('F Y'),  // Include month in the response
            'fuel_types' => $fuelTypeSales,   // Sales for each fuel type
            'total_sales' => $formattedTotalSales,
            'total_liters' => number_format($totalLiters, 2, '.', ''),
            'total_discount' => $formattedTotalDiscount,
        ];

        return response()->json([
            'message' => 'Monthly report generated successfully',
            'report' => $report
        ], 200);
    }
}
