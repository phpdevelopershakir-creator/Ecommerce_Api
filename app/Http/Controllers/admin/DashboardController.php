<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();

        // total amount (assuming column name = grand_total)
        $totalAmount = Order::sum('grand_total');

        return response()->json([
            'status' => 200,
            'data' => [
                'total_users' => $totalUsers,
                'total_products' => $totalProducts,
                'total_orders' => $totalOrders,
                'grand_total' => $totalAmount,
            ]
        ]);
    }

    public  function  getContact()
    {
        $contacts = Contact::orderBy('id', 'ASC')->get();
        return response()->json([
            'status' => 200,
            'data' => $contacts
        ]);
    }

    public function destroy(string $id)
    {
        $Contac = Contact::find($id);

        if (!$Contac) {
            return response()->json([
                'status' => 404,
                'message' => 'Contact Not Found',
            ], 404);
        }
        $Contac->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Contact Delete Successfully',
        ], 200);
    }
}
