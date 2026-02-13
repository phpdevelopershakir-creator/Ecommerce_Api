<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorControloler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $colors
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
        $color = new Color();
        $color->name = $request->name;
        $color->status = $request->status;
        $color->save();
        return response()->json([
            'status' => 200,
            'message' => 'Color Added Successfully',
            'data' => $color
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $color = Color::find($id);
        if ($color == null) {
            return response()->json([
                'status' => 400,
                'message' => 'Color Not Fund',
                'data' => []
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $color
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $color = Color::find($id);
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



        $color->update([
            'name' => $request->name,
            'status' => $request->status ?? $color->status,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Color Updated Successfully',
            'data' => $color,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = Color::find($id);

        if (!$color) {
            return response()->json([
                'status' => 404,
                'message' => 'Color Not Found',
            ], 404);
        }
        $color->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Color Delete Successfully',
        ], 200);
    }
}
