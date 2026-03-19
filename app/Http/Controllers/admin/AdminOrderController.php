<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function AdminOrder()
    {
        $orders = Order::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $orders
        ], 200);
    }

    public function AdminOrderDetails($id)
    {
        $order = Order::with('items', 'items.product')->find($id);
        if ($order == null) {
            return response()->json([
                'data' => [],
                'message' => 'Order Not Found',
                'status' => 404,
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'data' => $order
        ], 200);
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return response()->json([
                'data' => [],
                'message' => 'Order Not Found',
                'status' => 404,
            ], 404);
        }
        $order->status = $request->status;
        $order->payment_status = $request->payment_status;
        $order->save();
        return response()->json([
                'data' => $order,
                'status' => 200,
                'message' => 'Order Update Successfully',
                
            ], 200);
    }
}
