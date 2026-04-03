<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippings = Shipping::orderBy('id', 'ASC')->get();
        return response()->json([
            'status' => 200,
            'data' => $shippings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required',
            'cost' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }
        $shipping = new Shipping();
        $shipping->city = $request->city;
        $shipping->cost = $request->cost;
        $shipping->save();
        return response()->json([
            'status' => 200,
            'message' => 'Shipping Cost Added Successfully',
            'data' => $shipping
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shipping = Shipping::find($id);
        if ($shipping == null) {
            return response()->json([
                'status' => 400,
                'message' => 'Shipping Cost Not Fund',
                'data' => []
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $shipping
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $shipping = Shipping::find($id);
        $validator = Validator::make($request->all(), [
            'city' => 'required',
            'cost' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }



        $shipping->update([
            'city' => $request->city,
            'cost' => $request->cost,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Shipping Cost Updated Successfully',
            'data' => $shipping,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shipping = Shipping::find($id);
        if (!$shipping) {
            return response()->json([
                'status' => 404,
                'message' => 'Shipping Cost Not Found',
            ], 404);
        }
        $shipping->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Shipping Cost Delete Successfully',
        ], 200);
    }
}
