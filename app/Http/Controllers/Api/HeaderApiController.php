<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Header_footer; // Assuming you have a model to store image paths

class HeaderApiController extends Controller
{

    protected $baseUrl;    
    protected $imgUrl;    

    public function __construct()
    {
        
         $this->baseUrl = config('app.api_url');
         $this->imgUrl = config('app.img_url');
    }

    public function index()
    {
        // This will output both URLs for testing
       
        // Fetch the image path from the database
        $homeContent = Header_footer::first(); // Assuming you have only one record for simplicity
        // dd($homeContent->header_logo);
        if ($homeContent && $homeContent->header_logo) {
            $imagePath = $homeContent->header_logo;
            if (Storage::disk('public')->exists($imagePath)) {
                return response()->json([
                    'message' => 'Image retrieved successfully',
                    'image_path' => $this->imgUrl . '/' . $imagePath // Return the URL to the image
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
            $imagePath = $image->store('headerLogo', 'public');
            $db_img_path = $this->imgUrl . '/' . $imagePath;
            // Save the image path to the database
            $homeContent = Header_footer::updateOrCreate(
                [], // Update the first record or create if none exists
                ['header_logo' => $imagePath]
            );

            return response()->json([
                'message' => 'Image uploaded successfully',
                'image_path' => $db_img_path // Return the URL to the image
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

        $homeContent = Header_footer::first(); // Fetch the current record

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
        $homeContent = Header_footer::first(); // Fetch the current record

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
