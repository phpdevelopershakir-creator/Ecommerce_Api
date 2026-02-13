<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeControloler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = Size::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $sizes
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
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }
        $size = new Size();
        $size->name = $request->name;
        $size->status = $request->status;
        $size->save();
        return response()->json([
            'status' => 200,
            'message' => 'Size Added Successfully',
            'data' => $size
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $size = Size::find($id);
        if ($size == null) {
            return response()->json([
                'status' => 400,
                'message' => 'Size Not Fund',
                'data' => []
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $size
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $size = Size::find($id);
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



        $size->update([
            'name' => $request->name,
            'status' => $request->status ?? $size->status,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Size Updated Successfully',
            'data' => $size,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $size = Size::find($id);
        if (!$size) {
            return response()->json([
                'status' => 404,
                'message' => 'Size Not Found',
            ], 404);
        }
        $size->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Size Delete Successfully',
        ], 200);
    }
}
