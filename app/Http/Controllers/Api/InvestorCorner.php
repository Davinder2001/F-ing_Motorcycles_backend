<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Investor;

class InvestorCorner extends Controller
{
    protected $baseUrl;
    protected $imgUrl;

    public function __construct()
    {
        $this->baseUrl = config('app.api_url');
        $this->imgUrl = config('app.img_url');
    }

    // Method to list all investors
    public function index()
    {
        $investors = Investor::all();
        return response()->json([
            'message' => 'Investors retrieved successfully',
            'data' => $investors,
        ], 200);
    }

    // Method to store a new investor
    public function store(Request $request)
    {
        // Validate request using Validator
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'field1' => 'required|string',
            'field2' => 'required|string',
            'field3' => 'required|string',
            'field4' => 'required|string',
            'field5' => 'required|string',
            'field6' => 'required|string',
            'field7' => 'required|string',
            'field8' => 'required|string',
            'field9' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->only([
            'field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7', 'field8', 'field9'
        ]);

        $imagePath = null;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('investors', 'public');
        }

        // Save the investor to the database
        $investor = Investor::create(array_merge($data, [
            'image' => $imagePath,
        ]));

        return response()->json([
            'message' => 'Investor created successfully',
            'data' => [
                'id' => $investor->id,
                'image' => $imagePath ? $this->baseUrl . '/storage/' . $imagePath : null,
                'fields' => $data,
            ],
        ], 201);
    }

    // Method to update an existing investor
    public function update(Request $request, $id)
    {
        // Validate request using Validator
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'field1' => 'required|string',
            'field2' => 'required|string',
            'field3' => 'required|string',
            'field4' => 'required|string',
            'field5' => 'required|string',
            'field6' => 'required|string',
            'field7' => 'required|string',
            'field8' => 'required|string',
            'field9' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $investor = Investor::findOrFail($id);

        $currentImagePath = $investor->image;
        $data = $request->only([
            'field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7', 'field8', 'field9'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($currentImagePath && Storage::disk('public')->exists($currentImagePath)) {
                Storage::disk('public')->delete($currentImagePath);
            }

            $image = $request->file('image');
            $imagePath = $image->store('investors', 'public');
            $investor->image = $imagePath;
        }

        // Update investor details
        $investor->fill($data);
        $investor->save();

        return response()->json([
            'message' => 'Investor updated successfully',
            'data' => [
                'id' => $investor->id,
                'image' => $investor->image ? $this->baseUrl . '/storage/' . $investor->image : null,
                'fields' => $data,
            ],
        ], 200);
    }

    // Method to delete an investor
    public function destroy($id)
    {
        $investor = Investor::findOrFail($id);

        // Delete image if exists
        if ($investor->image && Storage::disk('public')->exists($investor->image)) {
            Storage::disk('public')->delete($investor->image);
        }

        // Delete the investor
        $investor->delete();

        return response()->json([
            'message' => 'Investor deleted successfully',
        ], 200);
    }
}
