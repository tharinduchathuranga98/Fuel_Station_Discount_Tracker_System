<?php

namespace App\Http\Controllers;

use App\Models\FuelType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FuelTypeController extends Controller
{
    public function create()
    {
        return view('fuel-type.create-fuel-type');
    }
    // Create a new fuel type
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:fuel_types,name',
            'price' => 'required|numeric',
        ]);

        // Ensure code is set
        $lastFuelType = FuelType::latest()->first();
        $nextNumber = $lastFuelType ? ((int)substr($lastFuelType->code, 5)) + 1 : 1;
        $code = 'FUEL-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Create the Fuel Type with Code
        $fuelType = FuelType::create([
            'code' => $code,
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return response()->json($fuelType, 201);
    }


    public function index(Request $request)
    {
        $query = FuelType::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $fuelTypes = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('fuel-type.fuel-type-management', compact('fuelTypes'));
    }
    // // Retrieve all fuel types
    // public function index()
    // {
    //     $fuelTypes = FuelType::orderBy('created_at', 'desc')->get();

    //     return response()->json($fuelTypes);
    // }

    // Retrieve a single fuel type
    public function show($id)
    {
        $fuelType = FuelType::find($id);

        if (!$fuelType) {
            return response()->json(['message' => 'Fuel type not found'], 404);
        }

        return view('fuel-type.edit-fuel-type', compact('fuelType'));
    }

    // public function edit($id)
    // {
    //     $fuelType = FuelType::where('id', $id)->first();

    //     if (!$fuelType) {
    //         return redirect()->route('fuel-type-management')->with('error', 'Vehicle not found.');
    //     }

    //     return view('fuel-type.edit-fuel-type', compact('fuelType'));
    // }
    // Update a fuel type
    public function update(Request $request, $id)
    {
        $fuelType = FuelType::find($id);

        if (!$fuelType) {
            return response()->json(['message' => 'Fuel type not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|unique:fuel_types,name,' . $id,
            'price' => 'sometimes|required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Manually update fields and ensure updated_at is modified
        $fuelType->fill($request->all());
        $fuelType->updated_at = now();
        $fuelType->save();

        return response()->json(['message' => 'Fuel type updated successfully', 'fuel_type' => $fuelType]);
    }



    // Delete a fuel type
    public function destroy($id)
    {
        $fuelType = FuelType::find($id);

        if (!$fuelType) {
            return response()->json(['message' => 'Fuel type not found'], 404);
        }

        $fuelType->delete();

        return response()->json(['message' => 'Fuel type deleted successfully']);
    }
}
