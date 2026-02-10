<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }
        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();
        return response()->json([
            'status' => 200,
            'message' => 'Category Added Successfully',
            'data' => $category
        ], 200);
    }


    public function show(string $id)
    {
        $category = Category::find($id);
        if ($category == null) {
            return response()->json([
                'status' => 400,
                'message' => 'Category Not Fund',
                'data' => []
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $category
        ]);
    }


    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'required|integer|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }



        $category->update([
            'name' => $request->name,
            'status' => $request->status ?? $category->status,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Category Updated Successfully',
            'data' => $category,
        ], 200);
    }


    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 404,
                'message' => 'Category Not Found',
            ], 404);
        }
        $category->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Category Delete Successfully',
        ], 200);
    }
}
