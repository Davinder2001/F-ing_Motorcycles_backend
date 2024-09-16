<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductPage; // Assuming you have a ProductPage model
use Validator;

class ProductPageApis extends Controller
{
    // List all product pages
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => ProductPage::all()
        ]);
    }

    // Store a new product page with SEO fields
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $productPage = ProductPage::create([
            'name' => $request->name,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'seo_keywords' => $request->seo_keywords
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product Page created successfully',
            'data' => $productPage
        ]);
    }

    // Show a specific product page
    public function show($id)
    {
        $productPage = ProductPage::find($id);

        if (!$productPage) {
            return response()->json(['status' => false, 'message' => 'Product Page not found'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $productPage
        ]);
    }

    // Update an existing product page with SEO fields
    public function update(Request $request, $id)
    {
        $productPage = ProductPage::find($id);

        if (!$productPage) {
            return response()->json(['status' => false, 'message' => 'Product Page not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $productPage->update([
            'name' => $request->name,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'seo_keywords' => $request->seo_keywords
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product Page updated successfully',
            'data' => $productPage
        ]);
    }

    // Delete a product page
    public function destroy($id)
    {
        $productPage = ProductPage::find($id);

        if (!$productPage) {
            return response()->json(['status' => false, 'message' => 'Product Page not found'], 404);
        }

        $productPage->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product Page deleted successfully'
        ]);
    }
}
