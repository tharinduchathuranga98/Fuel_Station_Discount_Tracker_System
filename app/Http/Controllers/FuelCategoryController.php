<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuelCategory;
use App\Models\FuelType;

class FuelCategoryController extends Controller
{
    // ✅ Get all categories
    public function index()
    {
        $categories = FuelCategory::orderBy('code', 'asc')->get();
        return response()->json($categories);
    }

    // ✅ Create a new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:fuel_categories,name',
            'fuel_type_code' => 'required|string|exists:fuel_types,code', // Ensure fuel type exists
            'discount_price' => 'required|numeric|min:0',
        ]);

        // Auto-generates code using the model boot method
        $category = FuelCategory::create([
            'name' => $request->name,
            'fuel_type_code' => $request->fuel_type_code,
            'discount_price' => $request->discount_price,
        ]);

        return response()->json(['message' => 'Category created successfully', 'category' => $category]);
    }

    // ✅ Get a single category
    public function show($code)
    {
        $category = FuelCategory::where('code', $code)->firstOrFail();
        return response()->json($category);
    }

    // ✅ Update a category
    public function update(Request $request, $code)
    {
        $category = FuelCategory::where('code', $code)->firstOrFail();

        $request->validate([
            'name' => 'sometimes|string|unique:fuel_categories,name,' . $category->id,
            'fuel_type_code' => 'sometimes|string|exists:fuel_types,code',
            'discount_price' => 'sometimes|numeric|min:0',
        ]);

        $category->update($request->only(['name', 'fuel_type_code', 'discount_price']));

        return response()->json(['message' => 'Category updated successfully', 'category' => $category]);
    }

    // ✅ Delete a category
    public function destroy($code)
    {
        $category = FuelCategory::where('code', $code)->firstOrFail();
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
