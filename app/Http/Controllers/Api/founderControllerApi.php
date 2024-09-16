<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Founder;
use Illuminate\Support\Facades\Storage;
use Validator;

class founderControllerApi extends Controller
{
    protected $baseUrl;    

    public function __construct()
    {
        $this->baseUrl = config('app.api_url');
    }

    // List all founders
    public function index()
    {
        $founders = Founder::all(['id','name', 'description', 'image']); // Fetch only the required fields

        $founders = $founders->map(function ($founder) {
            $founder->image = $founder->image ? $this->baseUrl . '/storage/' . $founder->image : null;
            return $founder;
        });

        return response()->json([
            'message' => 'Founders retrieved successfully',
            'data'    => $founders
        ], 200);
    }

    // Show a specific founder by ID
    public function show($id)
    {
        $founder = Founder::find($id, ['name', 'description', 'image']);

        if (!$founder) {
            return response()->json([
                'message' => 'Founder not found'
            ], 404);
        }

        $founder->image = $founder->image ? $this->baseUrl . '/storage/' . $founder->image : null;

        return response()->json([
            'message' => 'Founder retrieved successfully',
            'data'    => $founder
        ], 200);
    }

    // Create a new founder
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $founder = new Founder();
        $founder->name = $request->input('name');
        $founder->description = $request->input('description');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('founders', 'public');
            $founder->image = $imagePath;
        }

        $founder->save();

        return response()->json([
            'message' => 'Founder created successfully',
            'data'    => $founder
        ], 201);
    }

    // Update an existing founder by ID
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $founder = Founder::find($id);

        if (!$founder) {
            return response()->json([
                'message' => 'Founder not found'
            ], 404);
        }

        $founder->name = $request->input('name', $founder->name);
        $founder->description = $request->input('description', $founder->description);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($founder->image) {
                Storage::disk('public')->delete($founder->image);
            }

            $imagePath = $request->file('image')->store('founders', 'public');
            $founder->image = $imagePath;
        }

        $founder->save();

        return response()->json([
            'message' => 'Founder updated successfully',
            'data'    => $founder
        ], 200);
    }

    // Delete a founder by ID
    public function destroy($id)
    {
        $founder = Founder::find($id);

        if (!$founder) {
            return response()->json([
                'message' => 'Founder not found'
            ], 404);
        }

        // Delete image if exists
        if ($founder->image) {
            Storage::disk('public')->delete($founder->image);
        }

        $founder->delete();

        return response()->json([
            'message' => 'Founder deleted successfully'
        ], 200);
    }
}
