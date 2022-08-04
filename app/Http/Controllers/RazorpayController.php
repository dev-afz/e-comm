<?php

namespace App\Http\Controllers;

use Session;
use Exception;
use App\Models\Cart;
use Razorpay\Api\Api;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RazorpayController extends Controller
{
    // public function index(Request $request)
    // {
    //     return $unpaid = Orders::where('id',$request->id)->first();

    //     return view('orders.razorpayView',compact('total','order_ids'));
    // }
    public function store(Request $request)
    {
        $price = Orders::whereIn('id', $request->order_id)
            ->with(['product'])
            ->get();


        $prices = $price->map(function ($c) {
            return $c->quantity * $c->price;
        })->toArray();

        $total =  array_sum($prices);



        $user_id = $request->user()->id;
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);


        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $payment = $api->payment->fetch($request['razorpay_payment_id']);
        // return $payment->toArray();
        if (!empty($request['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($request['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
            } catch (Exception $e) {
                return  $e->getMessage();

                return redirect()->back();
            }
        }

        $total_payment = $response->amount;
        $actual_amout = $total_payment / 100;
        if ($total == $actual_amout) {
            foreach ($request->order_id as $id) {
                $ps = Orders::findOrFail($id);
                $ps->user_id = Auth::id();
                $ps->payment_status = 'paid';
                $ps->transaction_id = $response->id;
                $ps->save();
            }
            return redirect('/')->with('success', 'Your order has been placed successfully!');
        }
    }
}
