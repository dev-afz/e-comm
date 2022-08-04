<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //show cart item
    public function index()
    {

        $cartItem = Cart::where('user_id', Auth::id())
            ->with(['product'])
            ->get();
        return view('orders.cart', compact('cartItem'));
    }
    //ad to cart section
    public function store(Request $request)
    {
        // return($request);
        $user_id = $request->user()->id;
        $cart  =  $request->validate([
            'product_id' => 'required',
            'quantity' => 'required'
        ]);
        // dd($cart);
        if (Auth::check()) {
            $prod_check = Product::where('id', $request->product_id)->first();
            if ($prod_check) {
                if (Cart::where('product_id', $request->product_id)->where('user_id', $user_id)->first()) {
                    return redirect('/')->with('success', $prod_check->name . ' Already added to your cart');
                } else {
                    $cartItem =  Cart::create([
                        'user_id' => $user_id,
                        'product_id' => $request->product_id,
                        'prod_qty' => $request->quantity
                    ]);
                    return redirect('cart')->with('success', $prod_check->name . ' Added to your cart');
                }
            } else {
                return 'hihihihi';
            }
        } else {
            return response()->json(['status' => 'Login to continue']);
        }
    }
    //delete cart item
    public function deletecartitem(Request $request)
    {
        if (Auth::check()) {
            $prod_id = $request->input('product_id');
            if (Cart::where('product_id', $prod_id)->where('user_id', Auth::id())->exists()) {
                $cartitem = Cart::where('product_id', $prod_id)->where('user_id', Auth::id())->first();
                $cartitem->delete();
                return redirect('/')->with('success', 'Product deleted successfully');
            } else {
                return 'Something went wrong';
            }
        } else {
            return response()->jaon(['success', 'Login to continue']);
        }
    }
}
