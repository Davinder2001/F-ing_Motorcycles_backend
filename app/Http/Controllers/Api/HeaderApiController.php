<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\HomeContent; // Assuming you have a model to store image paths

class HeaderApiController extends Controller
{
    public function index()
    {
        // Fetch the image path from the database
        $homeContent = HomeContent::first(); // Assuming you have only one record for simplicity

        if ($homeContent && $homeContent->image_path) {
            $imagePath = $homeContent->image_path;

            if (Storage::disk('public')->exists($imagePath)) {
                return response()->json([
                    'message' => 'Image retrieved successfully',
                    'image_path' => Storage::disk('public')->url($imagePath) // Return the URL to the image
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
                ['image_path' => $imagePath]
            );

            return response()->json([
                'message' => 'Image uploaded successfully',
                'image_path' => Storage::disk('public')->url($imagePath) // Return the URL to the image
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

        if ($homeContent && $homeContent->image_path) {
            $currentImagePath = $homeContent->image_path;

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if (Storage::disk('public')->exists($currentImagePath)) {
                    Storage::disk('public')->delete($currentImagePath);
                }

                $image = $request->file('image');
                $imagePath = $image->store('home', 'public');
                dd($imagePath);

                // Update the image path in the database
                $homeContent->update(['image_path' => $imagePath]);

                return response()->json([
                    'message' => 'Image updated successfully',
                    'image_path' => Storage::disk('public')->url($imagePath) // Return the URL to the image
                ], 200);
            }
        }

        return response()->json([
            'message' => 'No image file provided or no image to update.'
        ], 400);
    }

    public function destroy()
    {
        $homeContent = HomeContent::first(); // Fetch the current record

        if ($homeContent && $homeContent->image_path) {
            $currentImagePath = $homeContent->image_path;

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
