<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('product.coupons.index', ['coupons' => $coupons]);
    }
    //store coupon
    public function store(Request $request)
    {
        // return $request->all();
        $coupon = $request->validate([
            'code' => 'required|unique:coupons,code',
            'coupontype' => 'required',
            'couponvalue' => 'required|numeric',
            'cartvalue' => 'required|numeric'
        ]);
        // return $coupon;
        Coupon::create([
            'code' => $request->code,
            'type' => $request->coupontype,
            'value' => $request->couponvalue,
            'cart_value' => $request->cartvalue
        ]);
        return redirect()->route('coupon.index');
    }
    //edit coupon details
    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:coupons,id'
        ]);
        $coupon = Coupon::findOrFail($request->id);
        return response($coupon);
    }
    public function updateCoupon(Request $request)
    {
        // return $request->all();
        $request->validate([
            'code' => 'required|unique:coupons',
            'coupontype' => 'required',
            'couponvalue' => 'required',
            'cartvalue' => 'required',
            'id' => 'required|exists:coupons,id'
        ]);
        $coupon = Coupon::findOrFail($request->id);
        // return $coupon;
        $coupon->code = $request->code;
        $coupon->type = $request->coupontype;
        $coupon->value = $request->couponvalue;
        $coupon->cart_value = $request->cartvalue;
        $coupon->save();
        return redirect([
            'message', 'Coupon updated successfully!'
        ])->route('coupon.index');
    }
    //delete coupons
    public function delete(Request $request)
    {
        $coupon = Coupon::findOrFail($request->id);
        $coupon->delete();
        return redirect()->route('coupon.index');
    }
}
