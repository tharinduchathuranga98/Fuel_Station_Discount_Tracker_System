<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuelCategory;
use App\Models\FuelType;

class FuelCategoryController extends Controller
{

    public function index(Request $request)
    {
        $query = FuelCategory::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");
        }


        $categorys = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('categorys.category-management', compact('categorys'));
    }


    // ✅ Create a new category
    public function create()
    {
        // Fetch all fuel types by their code
        $fuelTypes = FuelType::pluck('name', 'code');  // Key: code, Value: name

        return view('categorys.create-category', compact('fuelTypes'));
    }
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
        if (!$category) {
            return redirect()->route('category-management')->with('error', 'Category not found.');
        }
         // Fetch fuel types by their code
         $fuelTypes = FuelType::pluck('name', 'code');  // Key: code, Value: name
        // return response()->json($category);
        return view('categorys.edit-category', compact('category', 'fuelTypes'));

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

        // return response()->json(['message' => 'Category updated successfully', 'category' => $category]);
        return redirect()->route('category.edit', $category->code)
        ->with('success', 'Category updated successfully!');
    }

    // ✅ Delete a category
    public function destroy($code)
    {
        $category = FuelCategory::where('code', $code)->firstOrFail();
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
