<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function trackingstatus(Request $request)
    {
        $request->all();
        $status = $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'status' => 'required',
            'remark' => 'required'
        ]);
        OrderStatus::create([
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'status' => $request->status,
            'remark' => $request->remark
        ]);
    }
}
