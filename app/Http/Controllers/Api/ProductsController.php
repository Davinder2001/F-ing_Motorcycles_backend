<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Log;


class ProductsController extends Controller
{
    public function index(){
        
        $products = Product::all();
        if($products->count() > 0){

            return ProductResource::collection($products);

        }else{
            
            return response()->json(['message' => 'No recoad found'], 200);
        
        }

    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480',
        'description' => 'required',
        'category_id' => 'required|exists:categories,id',
    ]);

    $product = Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'product_image' => $request->image,
        'description' => $request->description,
        'category_id' => $request->category_id,
    ]);

    return response()->json([
        'message' => 'Product created successfully',
        'data' => new ProductResource($product)
    ], 200);
}

public function update(Request $request, Product $product)
{
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $request->image,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product)
        ], 200);
    } catch (\Exception $e) {
        Log::error('Product update failed: ' . $e->getMessage());
        return response()->json([
            'message' => 'Product update failed',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function show(Product $product){
     
        return new ProductResource($product);

    }


    public function destroy(Product $product){

        $product->delete();
        return response()->json([
            'message' => 'Product Deleted sucessfulley',
        ], 200);

    }
}
