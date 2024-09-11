<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeroSectionController extends Controller
{
    // Fetch 
    
    
    
    protected $baseUrl;    
    protected $imgUrl;    

    public function __construct()
    {
        $this->baseUrl = config('app.api_url');
        $this->imgUrl = config('app.img_url');
    }
    // Fetch all hero sections
    public function index()
    {
        $heroSections = HeroSection::all();

        // Add full image URL for each hero section
        $heroSections = $heroSections->map(function ($heroSection) {
            return [
                'id' => $heroSection->id,
                'text' => $heroSection->text,
                'image' => $heroSection->image ? $this->imgUrl .'/'. $heroSection->image : null,
            ];
        });

        return response()->json($heroSections, 200);
    }

    // Store a new hero section
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'text' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // image validation
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validatedData->errors(),
            ], 401);
        }

        // Handle image upload
        $imagePath = $this->handleImageUpload($request);

        // Create new hero section
        $heroSection = HeroSection::create([
            'text' => $request->input('text'),
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Hero section created successfully.',
            'data' => [
                'id' => $heroSection->id,
                'text' => $heroSection->text,
                'image' => $this->imgUrl . $heroSection->image,
            ],
        ], 201);
    }

    // Show a single hero section
    public function show(HeroSection $heroSection)
    {
        return response()->json([
            'id' => $heroSection->id,
            'text' => $heroSection->text,
            'image' => $heroSection->image ? $this->imgUrl . $heroSection->image : null,
        ], 200);
    }

    // Update a hero section
    public function update(Request $request, HeroSection $heroSection)
    {
        $validatedData = Validator::make($request->all(), [
            'text' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validatedData->errors(),
            ], 401);
        }

        // Update the image if provided
        if ($request->hasFile('image')) {
            $imagePath = $this->handleImageUpload($request);
            $heroSection->image = $imagePath;
        }

        $heroSection->text = $request->input('text', $heroSection->text);
        $heroSection->save();

        return response()->json([
            'message' => 'Hero section updated successfully.',
            'data' => [
                'id' => $heroSection->id,
                'text' => $heroSection->text,
                'image' => $heroSection->image ? $this->imgUrl . $heroSection->image : null,
            ],
        ], 200);
    }

    // Delete a hero section
    public function destroy(HeroSection $heroSection)
    {
        $heroSection->delete();
        return response()->json(['message' => 'Hero section deleted successfully.'], 200);
    }

    // Common function to handle image upload
    protected function handleImageUpload(Request $request)
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('hero_images', 'public');
        }
        return null;
    }
}