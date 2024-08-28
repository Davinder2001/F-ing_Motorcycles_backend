<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\HomeContent; // Assuming you have a model to store image paths

class HomeContentController extends Controller
{
    public function index()
    {
        // Fetch the image path from the database
        $homeContent = HomeContent::first(); // Assuming you have only one record for simplicity
    
        if ($homeContent && $homeContent->image) {
            $imagePath = $homeContent->image;
    
            if (Storage::disk('public')->exists($imagePath)) {
                $url = Storage::disk('public')->url($imagePath);
    
                // Ensure the URL includes the port number
                $url = str_replace('http://localhost', 'http://localhost:8000', $url);
    
                return response()->json([
                    'message' => 'Image retrieved successfully',
                    'image' => $url // Return the corrected URL to the image
                ], 200);
            }
        }
    
        return response()->json([
            'message' => 'No image found.'
        ], 404);
    }
    
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('home', 'public');

            // Save the image path to the database
            $homeContent = HomeContent::updateOrCreate(
                [], // Update the first record or create if none exists
                ['image' => $imagePath]
            );

            return response()->json([
                'message' => 'Image uploaded successfully',
                'image' => Storage::disk('public')->url($imagePath) // Return the URL to the image
            ], 200);
        }

        return response()->json([
            'message' => 'No image file provided.'
        ], 400);
    }
    public function update(Request $request)
    {
        // Validate request
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);
    
        $homeContent = HomeContent::first(); // Fetch the current record
    
        if (!$homeContent) {
            return response()->json([
                'message' => 'No content to update.'
            ], 404);
        }
    
        $currentImagePath = $homeContent->image;
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($currentImagePath && Storage::disk('public')->exists($currentImagePath)) {
                Storage::disk('public')->delete($currentImagePath);
            }
    
            $image = $request->file('image');
            $imagePath = $image->store('home', 'public');
    
            // Update the image path in the database
            $homeContent->image = $imagePath;
            $homeContent->save();
    
            return response()->json([
                'message' => 'Image updated successfully',
                'image' => Storage::disk('public')->url($imagePath)
            ], 200);
        }
    
        return response()->json([
            'message' => 'No image file provided for update.'
        ], 400);
    }
    
    
    public function destroy()
    {
        $homeContent = HomeContent::first(); // Fetch the current record

        if ($homeContent && $homeContent->image) {
            $currentImagePath = $homeContent->image;

            // Delete the image if exists
            if (Storage::disk('public')->exists($currentImagePath)) {
                Storage::disk('public')->delete($currentImagePath);
            }

            // Optionally, you can also delete the record from the database
            $homeContent->delete();

            return response()->json([
                'message' => 'Image deleted successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'No image file found to delete.'
        ], 400);
    }
}
