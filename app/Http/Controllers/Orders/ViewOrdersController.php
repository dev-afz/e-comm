<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\OrderDetails;
use App\Models\Orders;
use App\Models\Product;
use Illuminate\Http\Request;

class ViewOrdersController extends Controller
{
    public function pendingOrder()
    {
        $order = Orders::with(['details', 'product'])->latest()->where('status', 'pending')->get();
        return view('product.orders.pending-order', compact('order'));
    }
    public function acceptedOrder()
    {
        $order = Orders::with(['details', 'product'])->latest()->where('status', 'accepted')->get();
        return view('product.orders.accepted-order', compact('order'));
    }
    public function shippedOrder()
    {
        $order = Orders::with(['details', 'product'])->latest()->where('status', 'shipped')->get();
        return view('product.orders.shipped-order', compact('order'));
    }
    public function deliveredOrder()
    {
        $order = Orders::with(['details', 'product'])->latest()->where('status', 'delivered')->get();
        return view('product.orders.delivered-order', compact('order'));
    }
    public function cancelledOrder()
    {
        $order = Orders::with(['details', 'product'])->latest()->where('status', 'cancelled')->get();
        return view('product.orders.cancelled-order', compact('order'));
    }
    public function updateStatus(Request $request)
    {
        // return $request->all();
        $status = $request->validate([
            'id' => 'required|exists:orders,id',
            'status' => 'required'
        ]);
        $order = Orders::findOrFail($request->id);
        $order->status = $request['status'];
        $order->save();
        return response('Status changed successfully!');
    }
}
