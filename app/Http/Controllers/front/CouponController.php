<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'amount' => 'required|numeric|min:0'
        ]);

        $amount = $request->amount; // এটা subtotal

        $coupon = Coupon::where('code', $request->code)->first();

        // ❌ Not found
        if (!$coupon) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid coupon code'
            ], 404);
        }

        // ❌ Inactive
        if (!$coupon->status) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon inactive'
            ], 400);
        }

        // ❌ Expired
        if ($coupon->expire_date && Carbon::now()->gt($coupon->expire_date)) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon expired'
            ], 400);
        }

        $discount = 0;

        // ✅ Discount calculation
        if ($coupon->type == 'fixed') {
            $discount = $coupon->value;
        } else {
            $discount = ($amount * $coupon->value) / 100;
        }

        // ❗ discount amount এর বেশি না হয়
        $discount = min($discount, $amount);

        $finalAmount = $amount - $discount;

        return response()->json([
            'status' => true,
            'message' => 'Coupon applied successfully',
            'data' => [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'original_amount' => $amount,
                'discount' => $discount,
                'final_amount' => $finalAmount
            ]
        ]);
    }
}
