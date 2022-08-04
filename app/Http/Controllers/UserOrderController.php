<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function index(Request $request)
    {
        $order_list =  Orders::with(['details', 'product', 'user'])->latest()->where('user_id', $request->user()->id)->get();
        return view('orders.your-order', compact('order_list'));
    }
    public function showorderdetails(Request $request)
    {
        $show =  Orders::with(['details', 'product', 'user'])->latest()->where('id', $request->id)->first();
        return view('orders.view-order-detail', compact('show'));
    }
    //unpaid order amount section
    // public function unpaidorder(Request $request)
    // {
    //     $unpaid = Orders::where('id', $request->id)->get();
    //     $price = $unpaid->map(function ($c) {
    //         return $c->quantity * $c->price;
    //     })->toArray();

    //     $total = array_sum($price);
    //     $order_ids = $request->id;
    //     return view('orders.your-order',compact('total','order_ids'));
    // }
}
