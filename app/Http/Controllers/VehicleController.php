<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\RefuelingRecord;
use Illuminate\Http\Request;
use App\Helpers\QrCodeHelper;
use Illuminate\Support\Facades\Validator;
use App\Helpers\SmsHelper;
use Carbon\Carbon;
use App\Models\FuelType;
use App\Models\FuelCategory;


class VehicleController extends Controller
{


    public function index(Request $request)
    {
        $query = Vehicle::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('number_plate', 'LIKE', "%{$search}%")
                ->orWhere('owner_name', 'LIKE', "%{$search}%")
                ->orWhereHas('fuelType', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        }

        // $vehicles = $query->paginate(10);
        // Order by created_at in descending order to get latest records first
        $vehicles = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('vehicles.vehicle-management', compact('vehicles'));
    }

    public function checkVehicle(Request $request)
    {
        // Validate request input
        $request->validate([
            'number_plate' => 'required|string|max:255',
        ]);

        // Find vehicle by number plate
        $vehicle = Vehicle::where('number_plate', $request->number_plate)->first();

        if ($vehicle) {
            return response()->json([
                "success" => true,
                "message" => "Vehicle found",
                "data" => [
                    "number_plate" => $vehicle->number_plate,
                    "owner_name" => $vehicle->owner_name,
                    "fuel_type" => $vehicle->fuelType->name,
                ]
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Vehicle not found",
            ], 404);
        }
    }


    public function create()
    {
        // Fetch all fuel types by their code
        $fuelTypes = FuelType::pluck('name', 'code');  // Key: code, Value: name

        // Fetch categories (you can modify this logic if you want categories to be pre-filtered)
        $categories = FuelCategory::pluck('name', 'code');  // Fetch all categories or adjust if needed

        // Pass null for vehicle as it's a new entry, and pass fuelTypes and categories
        return view('vehicles.create-vehicle', compact('fuelTypes', 'categories'));
    }

    public function register(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'number_plate' => 'required|unique:vehicles,number_plate',
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string|max:9|regex:/^[0-9]{9}$/', // Validate 9 digits
            'fuel_type' => 'required|exists:fuel_types,code',
            'category' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400); // Return errors in JSON format
        }

        // Prepend '94' to the phone number
        $ownerPhone = '94' . $request->owner_phone;

        // Generate QR Code in Base64
        $qrCodeBase64 = QrCodeHelper::generateQrCode($request->number_plate);

        // Store vehicle in database
        $vehicle = Vehicle::create([
            'number_plate' => $request->number_plate,
            'owner_name' => $request->owner_name,
            'owner_phone' => $ownerPhone, // Store the phone number with '94' prepended
            'fuel_type' => $request->fuel_type,
            'category' => $request->category,
            'qr_code' => $qrCodeBase64  // Store Base64 QR code
        ]);

        // Generate QR Code Download Link
        $qrCodeUrl = url('/api/vehicles/' . $vehicle->id . '/qr-code');

        // Prepare SMS message
        $message = "Hello {$request->owner_name}, your vehicle ({$request->number_plate}) is registered. Download your QR code: $qrCodeUrl";

        // Send SMS
        SmsHelper::sendSms($vehicle->owner_phone, $message);

        // return response()->json([
        //     'message' => 'Vehicle registered successfully. SMS sent.',
        //     'vehicle' => $vehicle,
        //     'qr_code_url' => $qrCodeUrl
        // ], 201);
        return redirect()->route('vehicles.create', $vehicle->number_plate)
            ->with('success', 'Vehicle updated successfully!');
    }


    public function getQrCode($id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle || empty($vehicle->qr_code)) {
            return response()->json(['message' => 'QR code not found'], 404);
        }

        $qrCodeBase64 = $vehicle->qr_code;
        $qrCodeData = base64_decode($qrCodeBase64);

        return response($qrCodeData)
            ->header('Content-Type', 'image/png');
    }

    public function edit($number_plate)
    {
        $vehicle = Vehicle::where('number_plate', $number_plate)->first();

        if (!$vehicle) {
            return redirect()->route('vehicle-management')->with('error', 'Vehicle not found.');
        }

        // Fetch fuel types by their code
        $fuelTypes = FuelType::pluck('name', 'code');  // Key: code, Value: name
        // Fetch categories that belong to selected fuel type
        $categories = FuelCategory::where('code', $vehicle->fuel_type)->pluck('name', 'code');

        return view('vehicles.edit-vehicle', compact('vehicle', 'fuelTypes', 'categories'));
    }

    public function getCategoriesByFuelType(Request $request)
    {
        // Get the fuel type code from the request
        $fuelTypeCode = $request->input('fuel_type_code');

        // Fetch the categories by fuel type code
        $categories = FuelCategory::where('fuel_type_code', $fuelTypeCode)->get();

        // Prepare data in the form of an array with code as the key and name as the value
        $categoriesData = $categories->pluck('name', 'code');

        // Return the categories in the correct format
        return response()->json($categoriesData);
    }





    public function getUserRefuelingData(Request $request)
    {
        // Validate the number plate from the request
        $request->validate([
            'number_plate' => 'required|string',
        ]);

        // Get the vehicle based on number plate
        $vehicle = Vehicle::where('number_plate', $request->number_plate)->first();

        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        // Get the total refueling for the current month
        $totalRefueled = RefuelingRecord::where('number_plate', $request->number_plate)
            ->whereMonth('refueled_at', Carbon::now()->month)
            ->sum('liters');

        // Prepare the data to return
        $data = [
            'vehicle' => $vehicle,
            'total_refueling_for_month' => $totalRefueled
        ];

        return response()->json($data, 200);
    }

    public function updateVehicle(Request $request, $number_plate)
    {
        // Find the vehicle
        $vehicle = Vehicle::where('number_plate', $number_plate)->first();

        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string|max:9|regex:/^[0-9]{9}$/', // Validate 9 digits
            'fuel_type' => 'required|string|max:50',
            'category' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // If 'owner_phone' is provided, prepend '94' to it
        if ($request->has('owner_phone')) {
            $request->merge(['owner_phone' => '94' . $request->owner_phone]);
        }

        // Update vehicle details
        $vehicle->update($request->only(['owner_name', 'owner_phone', 'fuel_type', 'category']));

        // Success message
        $message = "Dear {$vehicle->owner_name}, Your vehicle profile has been successfully updated. Number Plate: {$vehicle->number_plate}";
        SmsHelper::sendSms($vehicle->owner_phone, $message);

        // Flash success message to session
        session()->flash('success', 'Vehicle updated successfully.');

        // Redirect to the vehicle management page
        // return redirect()->route('vehicle-management');
        return redirect()->route('vehicles.edit', $vehicle->number_plate)
            ->with('success', 'Vehicle updated successfully!');
    }


    public function deleteVehicle($number_plate)
    {
        // Find the vehicle
        $vehicle = Vehicle::where('number_plate', $number_plate)->first();

        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        // Delete vehicle
        $vehicle->delete();

        // return response()->json(['message' => 'Vehicle deleted successfully']);
        return redirect()->route('vehicle-management')->with('success', 'Vehicle deleted successfully');
    }
}
