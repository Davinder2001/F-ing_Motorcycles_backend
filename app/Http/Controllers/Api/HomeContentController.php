<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\HomeContent;

class HomeContentController extends Controller
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
        // Fetch the home content from the database
        $homeContent = HomeContent::first(); // Assuming you have only one record for simplicity
        if ($homeContent) {
            $response = [
                'message'       => 'Content retrieved successfully',
                'heading'       => $homeContent->heading,
                'heading_nxt'   => $homeContent->heading_nxt,
                'description'   => $homeContent->description,
                'image'         => $homeContent->image ? $this->baseUrl . '/storage/' . $homeContent->image : null,
                'button_1'      => $homeContent->button_1, // Added field
                'image_2'       => $homeContent->image_2 ? $this->baseUrl . '/storage/' . $homeContent->image_2 : null,
                'Sub_heading_2' => $homeContent->Sub_heading_2,
                'heading_2'     => $homeContent->heading_2,
                'description_2' => $homeContent->description_2,
                'button_2'      => $homeContent->button_2,
            ];

            return response()->json($response, 200);
        }

        return response()->json([
            'message' => 'No content found.'
        ], 404);
    }

    public function store(Request $request)
    {
        // Validate request using Validator
        $validator = Validator::make($request->all(), [
            'heading' => 'required|string|max:255',
            'heading_nxt' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'Sub_heading_2' => 'required|string|max:255',
            'heading_2' => 'required|string|max:255',
            'description_2' => 'required|string',
            'button_1' => 'required|string|max:255', // Added field
            'button_2' => 'required|string|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $imagePath = null;
        $image2Path = null;

        // Handle image uploads
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('home', 'public');
        }

        if ($request->hasFile('image_2')) {
            $image2 = $request->file('image_2');
            $image2Path = $image2->store('home', 'public');
        }

        // Save the content to the database
        $homeContent = HomeContent::updateOrCreate(
            [], // Update the first record or create if none exists
            [
                'heading' => $request->heading,
                'heading_nxt' => $request->heading_nxt,
                'description' => $request->description,
                'image' => $imagePath,
                'image_2' => $image2Path,
                'Sub_heading_2' => $request->Sub_heading_2,
                'heading_2' => $request->heading_2,
                'description_2' => $request->description_2,
                'button_1' => $request->button_1, // Added field
                'button_2' => $request->button_2,
            ]
        );

        return response()->json([
            'message' => 'Content uploaded successfully',
            'heading' => $homeContent->heading,
            'heading_nxt' => $homeContent->heading_nxt,
            'description' => $homeContent->description,
            'image' => $imagePath ? $this->baseUrl . '/storage/' . $imagePath : null,
            'image_2' => $image2Path ? $this->baseUrl . '/storage/' . $image2Path : null,
            'Sub_heading_2' => $homeContent->Sub_heading_2,
            'heading_2' => $homeContent->heading_2,
            'description_2' => $homeContent->description_2,
            'button_1' => $homeContent->button_1, // Added field
            'button_2' => $homeContent->button_2,
        ], 200);
    }

    public function update(Request $request)
    {
        // Validate request using Validator
        $validator = Validator::make($request->all(), [
            'heading' => 'required|string|max:255',
            'heading_nxt' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'Sub_heading_2' => 'required|string|max:255',
            'heading_2' => 'required|string|max:255',
            'description_2' => 'required|string',
            'button_1' => 'required|string|max:255', // Added field
            'button_2' => 'required|string|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $homeContent = HomeContent::first(); // Fetch the current record

        if (!$homeContent) {
            return response()->json([
                'message' => 'No content to update.'
            ], 404);
        }

        $currentImagePath = $homeContent->image;
        $currentImage2Path = $homeContent->image_2;

        // Handle image uploads
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($currentImagePath && Storage::disk('public')->exists($currentImagePath)) {
                Storage::disk('public')->delete($currentImagePath);
            }

            $image = $request->file('image');
            $imagePath = $image->store('home', 'public');
            $homeContent->image = $imagePath;
        }

        if ($request->hasFile('image_2')) {
            // Delete old image_2 if exists
            if ($currentImage2Path && Storage::disk('public')->exists($currentImage2Path)) {
                Storage::disk('public')->delete($currentImage2Path);
            }

            $image2 = $request->file('image_2');
            $image2Path = $image2->store('home', 'public');
            $homeContent->image_2 = $image2Path;
        }

        // Update other fields
        $homeContent->heading = $request->heading;
        $homeContent->heading_nxt = $request->heading_nxt;
        $homeContent->description = $request->description;
        $homeContent->Sub_heading_2 = $request->Sub_heading_2;
        $homeContent->heading_2 = $request->heading_2;
        $homeContent->description_2 = $request->description_2;
        $homeContent->button_1 = $request->button_1; // Added field
        $homeContent->button_2 = $request->button_2;
        $homeContent->save();

        return response()->json([
            'message' => 'Content updated successfully',
            'heading' => $homeContent->heading,
            'heading_nxt' => $homeContent->heading_nxt,
            'description' => $homeContent->description,
            'image' => $homeContent->image ? $this->baseUrl . '/storage/' . $homeContent->image : null,
            'image_2' => $homeContent->image_2 ? $this->baseUrl . '/storage/' . $homeContent->image_2 : null,
            'Sub_heading_2' => $homeContent->Sub_heading_2,
            'heading_2' => $homeContent->heading_2,
            'description_2' => $homeContent->description_2,
            'button_1' => $homeContent->button_1, // Added field
            'button_2' => $homeContent->button_2,
        ], 200);
    }

    public function destroy()
    {
        $homeContent = HomeContent::first(); // Fetch the current record

        if (!$homeContent) {
            return response()->json([
                'message' => 'No content to delete.'
            ], 404);
        }

        // Delete images if they exist
        if ($homeContent->image && Storage::disk('public')->exists($homeContent->image)) {
            Storage::disk('public')->delete($homeContent->image);
        }

        if ($homeContent->image_2 && Storage::disk('public')->exists($homeContent->image_2)) {
            Storage::disk('public')->delete($homeContent->image_2);
        }

        // Delete the content
        $homeContent->delete();

        return response()->json([
            'message' => 'Content deleted successfully'
        ], 200);
    }
}
