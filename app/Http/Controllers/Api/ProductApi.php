<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Models\Api\Products;
use Illuminate\Http\Request;

class ProductApi extends Controller
{
    //get live product
    public function getallproduct()
    {
        return response(Products::where('status', 1)->get(), 200);
    }
    //get product by id
    public function getProductById($id)
    {
        $product = Products::where('status', 1)->find($id);
        if (is_null($product)) {
            return response()->json(['message' => 'Record not found']);
        }
        return response()->json($product, 200);
    }
    //add product
    public function addProduct(Request $request)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
            'description' => 'required',
        ]);
        $image = FileUploader::uploadFile($request->file('image'), 'image/products');
        $product = Products::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $image,
            'description' => $request->description
        ]);
        if ($product) {
            return response()->json($product, 201);
        }
        return response()->json(['message' => 'Something went wrong']);
    }
    //edit product
    public function updateProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
            'description' => 'required'
        ]);
        $product = Products::find($request->id);
        if ($request->image) {
            $img = FileUploader::uploadFile($request->file('image'), 'images/products');
            $product->image = $img;
        }
        if (is_null($product)) {
            return response()->json(["message" => "Record not found"]);
        }
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();
        return response(["message" => "Product details updated successfully!", "data" => $product], 200);
    }
    //delete product
    public function delete(Request $request)
    {
        $product = Products::find($request->id);
        if (is_null($product)) {
            return response(['message' => 'No product found', 'status' => 404]);
        }
        $product->delete();
        return response(['message' => 'Product deleted successfully'], 200);
    }
}
