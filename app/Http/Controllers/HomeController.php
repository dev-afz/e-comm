<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->filter(request(['search']))->where('status', 1)->get();
        return view('users.index',compact('products'));
    }
}
