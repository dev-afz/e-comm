<?php

namespace App\Http\Controllers;

use DOMDocument;
use App\Models\Cart;
use App\Models\Orders;
use App\Models\Product;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index(Product $product)
    {
        $product = $product;
        return view('orders.index', compact('product'));
    }

    //show place order details
    public function paymentDetail()
    {
        $cartitems = Cart::where('user_id', Auth::id())
            ->with(['product'])
            ->get();
        // dd($product);
        return view('orders.order-details', compact('cartitems'));
    }
    public function placeorder(Request $request)
    {
        if ($request->payment_type == 'online') {

            $request->all();


            $user_id = $request->user()->id;
            $request->validate([
                'product_id' => 'required',
                'fname' => 'required',
                'lname' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'pincode' => 'required',
                'city' => 'required',
                'state' => 'required',
                'quantity' => 'required',
                'price' => 'required',
                'payment_type' => 'required',
            ]);
            $order_ids = [];
            return DB::transaction(function () use ($request, $user_id, $order_ids) {
                $cartitems = Cart::where('user_id', Auth::id())->with(['product'])->get();
                $total = 0;
                foreach ($cartitems as $key => $order) {

                    $order_ids[$key] =   $ord =  Orders::create([
                        'product_id' => $order->product_id,
                        'user_id' => $user_id,
                        'quantity' => $order->prod_qty,
                        'price' => $order->product->price,
                        'total' => $order->product->price * $order->prod_qty,
                        'payment_type' => $request->payment_type,
                    ]);
                    $ord->details()->create([
                        'product_id' => $request->product_id,
                        'user_id' => $user_id,
                        'fname' => $request->fname,
                        'lname' => $request->lname,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'pincode' => $request->pincode,
                        'city' => $request->city,
                        'state' => $request->state,
                    ]);
                    $total += $order->product->price * $order->prod_qty;
                }

                $cartitems = Cart::where('user_id', Auth::id())->get();
                Cart::destroy($cartitems);
                return view('orders.razorpayView', compact('total', 'order_ids'));
            });
        } else {
            // dd($request->toArray());
            $request->all();

            $cart = Cart::whereIn('id', $request->cart)
                ->with(['product'])
                ->get();


            $prices = $cart->map(function ($c) {
                return $c->prod_qty * $c->product->price;
            });
            // return  array_sum($prices);



            $user_id = $request->user()->id;
            $r = $request->validate([
                'product_id' => 'required',
                'fname' => 'required',
                'lname' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'pincode' => 'required',
                'city' => 'required',
                'state' => 'required',
                'quantity' => 'required',
                'price' => 'required',
                'payment_type' => 'required'
            ]);
            DB::transaction(function () use ($request, $user_id) {
                $cartitems = Cart::where('user_id', Auth::id())->with(['product'])->get();
                foreach ($cartitems as $order) {
                    $order =  Orders::create([
                        'product_id' => $order->product_id,
                        'user_id' => $user_id,
                        'quantity' => $order->prod_qty,
                        'price' => $order->product->price,
                        'total' => $order->product->price * $order->prod_qty,
                        'payment_type' => $request->payment_type,
                        'transaction_id' => 'COD'
                    ]);
                }

                $order->details()->create([
                    'product_id' => $request->product_id,
                    'user_id' => $user_id,
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'pincode' => $request->pincode,
                    'city' => $request->city,
                    'state' => $request->state,
                ]);
            });

            $cartitems = Cart::where('user_id', Auth::id())->get();
            Cart::destroy($cartitems);

            return redirect('/')->with('success', 'Your order has been placed successfully!');
        }
    }
}
    