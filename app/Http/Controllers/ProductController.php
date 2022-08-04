<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\FileUploader;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->where('status',0)->get();
        return view('product.product-add',compact('products'));
    }
    public function store(Request $request)
    {
        $product = $request->validate([
            'name'=>'required|string',
            'price'=>'required',
            'image'=>'required',
            'description'=>'required'
        ]);
        // dd($product);
        $img = FileUploader::uploadFile($request->file('image'),'images/students');
        Product::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'image'=>$img,
            'description'=>$request->description
        ]);

        return redirect()->route('product.index');
    }
    public function edit(Request $request)
    {
        $request->validate([
            'id'=> 'required|exists:products,id'
        ]);
        $product = Product::findOrFail($request->id);
        // dd($products);
        return response($product);
    }
    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required',
            'image'=>'image|nullable',
            'description'=>'required',
            'id'=>'required|exists:products,id'
        ]);
        $product = Product::findOrFail($request->id);
        if($request->image){
            $img = FileUploader::uploadFile($request->file('image'),'images/students');
            $product->image = $img;
        }
        $product->name = $request['name'];
        $product->price = $request['price'];
        $product->description = $request['description'];
        $product->save();
        return response([
            'message','Product Details Updated Succeccfully!'
        ]);
    }
    public function delete(Request $request)
    {
        $product = Product::findOrFail($request->id);
        if(!is_null($product))
        {
            $product->delete();
        }
        return response([
            'message'=>'Record deleted'
        ]);
    }
    //change product status
    public function updatestatus(Request $request)
    {
        $pro = $request->validate([
            'id'=>'required|exists:products,id',
            'status'=>'required'
        ]);
        $product = Product::findOrFail($request->id);
        $product->status = $request['status'];
        $product->save();
        return response('Status change successfully!');

    }
}
