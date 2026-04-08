<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $socials = Social::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $socials
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'icon' => 'required',
            'link' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }
        $social = new Social();
        $social->icon = $request->icon;
        $social->link = $request->link;
        $social->save();
        return response()->json([
            'status' => 200,
            'message' => 'Social Added Successfully',
            'data' => $social
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $social = Social::find($id);
        if ($social == null) {
            return response()->json([
                'status' => 400,
                'message' => 'Social Not Fund',
                'data' => []
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $social
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $social = Social::find($id);
        $validator = Validator::make($request->all(), [
            'icon' => 'required',
            'link' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }



        $social->update([
            'name' => $request->name,
            'status' => $request->status ?? $social->status,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Social Updated Successfully',
            'data' => $social,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $social = Social::find($id);

        if (!$social) {
            return response()->json([
                'status' => 404,
                'message' => 'Social Not Found',
            ], 404);
        }
        $social->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Social Delete Successfully',
        ], 200);
    }
}
