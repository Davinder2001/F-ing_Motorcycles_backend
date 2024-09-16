<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutUs;
use Validator;
use App\Http\Resources\AboutUsResource;

class AboutUsController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        return AboutUsResource::collection(AboutUs::all());
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'seoTitle' => 'nullable|string', // Add validation rules for SEO fields
            'seoDescription' => 'nullable|string',
            'seoHostUrl' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $aboutUs = AboutUs::create([
            'title' => $request->title,
            'description' => $request->description,
            'seoTitle' => $request->seoTitle, // Add SEO fields to creation
            'seoDescription' => $request->seoDescription,
            'seoHostUrl' => $request->seoHostUrl
        ]);

        return response()->json([
            'status' => true,
            'message' => 'About Us content created successfully',
            'data' => $aboutUs
        ]);
    }

    // Display the specified resource
    public function show($id)
    {
        $aboutUs = AboutUs::find($id);

        if (!$aboutUs) {
            return response()->json(['status' => false, 'message' => 'About Us content not found'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $aboutUs
        ]);
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $aboutUs = AboutUs::find($id);

        if (!$aboutUs) {
            return response()->json(['status' => false, 'message' => 'About Us content not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'seoTitle' => 'nullable|string', // Add validation rules for SEO fields
            'seoDescription' => 'nullable|string',
            'seoHostUrl' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $aboutUs->update([
            'title' => $request->title,
            'description' => $request->description,
            'seoTitle' => $request->seoTitle, // Add SEO fields to update
            'seoDescription' => $request->seoDescription,
            'seoHostUrl' => $request->seoHostUrl
        ]);

        return response()->json([
            'status' => true,
            'message' => 'About Us content updated successfully',
            'data' => $aboutUs
        ]);
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $aboutUs = AboutUs::find($id);

        if (!$aboutUs) {
            return response()->json(['status' => false, 'message' => 'About Us content not found'], 404);
        }

        $aboutUs->delete();

        return response()->json([
            'status' => true,
            'message' => 'About Us content deleted successfully'
        ]);
    }
}
