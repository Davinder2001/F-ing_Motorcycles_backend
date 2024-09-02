<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\HomeContent;

class HomeContentController extends Controller
{
    protected $baseUrl;

    public function __construct()
    {
        // Fetch the base URL from the environment file
        $this->baseUrl = env('API_URL', 'http://localhost:8000');
    }

    public function index()
    {
        // Fetch the home content from the database
        $homeContent = HomeContent::first(); // Assuming you have only one record for simplicity

        if ($homeContent) {
            $response = [
                'message' => 'Content retrieved successfully',
                'heading' => $homeContent->heading,
                'description' => $homeContent->description,
                'image' => null
            ];

            if ($homeContent->image && Storage::disk('public')->exists($homeContent->image)) {
                $response['image'] = $this->baseUrl . '/storage/' . $homeContent->image;
            }

            return response()->json($response, 200);
        }

        return response()->json([
            'message' => 'No content found.'
        ], 404);
    }

    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'heading' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);

        $imagePath = null;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('home', 'public');
        }

        // Save the content to the database
        $homeContent = HomeContent::updateOrCreate(
            [], // Update the first record or create if none exists
            [
                'heading' => $request->heading,
                'description' => $request->description,
                'image' => $imagePath,
            ]
        );

        return response()->json([
            'message' => 'Content uploaded successfully',
            'heading' => $homeContent->heading,
            'description' => $homeContent->description,
            'image' => $imagePath ? $this->baseUrl . '/storage/' . $imagePath : null,
        ], 200);
    }

    public function update(Request $request)
    {
        // Validate request
        $request->validate([
            'heading' => 'required|string|max:255',
            'description' => 'required|string',
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
            $homeContent->image = $imagePath;
        }

        // Update the heading and description
        $homeContent->heading = $request->heading;
        $homeContent->description = $request->description;
        $homeContent->save();

        return response()->json([
            'message' => 'Content updated successfully',
            'heading' => $homeContent->heading,
            'description' => $homeContent->description,
            'image' => $homeContent->image ? $this->baseUrl . '/storage/' . $homeContent->image : null,
        ], 200);
    }

    public function destroy()
    {
        $homeContent = HomeContent::first(); // Fetch the current record

        if ($homeContent) {
            $currentImagePath = $homeContent->image;

            // Delete the image if exists
            if ($currentImagePath && Storage::disk('public')->exists($currentImagePath)) {
                Storage::disk('public')->delete($currentImagePath);
            }

            // Optionally, you can also delete the record from the database
            $homeContent->delete();

            return response()->json([
                'message' => 'Content deleted successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'No content found to delete.'
        ], 400);
    }
}
