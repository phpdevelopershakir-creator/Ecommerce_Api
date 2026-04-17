<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'ASC')->get();
        return response()->json([
            'status' => 200,
            'data' => $coupons
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required',
            'value' => 'required',
            'expire_date' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ], 400);
        }
        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->expire_date = Carbon::parse($request->expire_date)->format('Y-m-d');
        $coupon->status = $request->status;
        $coupon->save();
        return response()->json([
            'status' => 200,
            'message' => 'Coupon Added Successfully',
            'data' => $coupon
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $coupon = Coupon::find($id);
        if ($coupon == null) {
            return response()->json([
                'status' => 400,
                'message' => 'Coupon Not Fund',
                'data' => []
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $coupon
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coupon = Coupon::find($id);
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required',
            'value' => 'required',
            'expire_date' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }




        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->expire_date = Carbon::parse($request->expire_date)->format('Y-m-d');
        $coupon->status = $request->status;
        $coupon->save();


        return response()->json([
            'status' => 200,
            'message' => 'Coupon Updated Successfully',
            'data' => $coupon,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'status' => 404,
                'message' => 'Coupon Not Found',
            ], 404);
        }
        $coupon->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Coupon Delete Successfully',
        ], 200);
    }
}
