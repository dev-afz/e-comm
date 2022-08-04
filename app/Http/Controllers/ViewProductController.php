<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ViewProductController extends Controller
{
    //view live product
    public function index()
    {
        $product = Product::latest()->where('status',1)->get();

        return view('product.view-product',compact('product'));
    }
    //view deleted product
    public function deleted()
    {
        $product = Product::latest()->where('status',2)->get();

        return view('product.deleted-product',compact('product'));
    }

}
