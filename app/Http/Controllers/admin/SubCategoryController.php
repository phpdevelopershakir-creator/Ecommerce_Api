<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = SubCategory::with('category')->orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $subcategories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }
        $subcategory = new SubCategory();
        $subcategory->name = $request->name;
        $subcategory->status = $request->status;
        $subcategory->category_id = $request->category_id;
        $subcategory->save();
        return response()->json([
            'status' => 200,
            'message' => 'Subcategory Added Successfully',
            'data' => $subcategory
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subcategory = SubCategory::find($id);
        if ($subcategory == null) {
            return response()->json([
                'status' => 400,
                'message' => 'Subcategory Not Fund',
                'data' => []
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $subcategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subcategory = SubCategory::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }



        $subcategory->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'status' => $request->status ?? $subcategory->status,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Subcategory Updated Successfully',
            'data' => $subcategory,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subcategory = SubCategory::find($id);

        if (!$subcategory) {
            return response()->json([
                'status' => 404,
                'message' => 'Subcategory Not Found',
            ], 404);
        }
        $subcategory->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Subcategory Delete Successfully',
        ], 200);
    }
}
