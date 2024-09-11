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
                'message'            => 'Content retrieved successfully',
                'id'                 =>$homeContent->id,
                'heading'            => $homeContent->heading,
                'heading_nxt'        => $homeContent->heading_nxt,
                'description'        => $homeContent->description,
                'heading_2'          => $homeContent->heading_2,
                'Sub_heading_2'      => $homeContent->Sub_heading_2,
                's_description_1'    => $homeContent->s_description_1,
                's_description_2'    => $homeContent->s_description_2,
                's_description_3'    => $homeContent->s_description_3,
                'description_2'      => $homeContent->description_2,
                'image'              => $homeContent->image ? $this->baseUrl . '/storage/' . $homeContent->image : null,
                'image_2'            => $homeContent->image_2 ? $this->baseUrl . '/storage/' . $homeContent->image_2 : null,
                'third_sec_heading'  => $homeContent->third_sec_heading,
                'image_1_sec_3'      => $homeContent->image_1_sec_3 ? $this->baseUrl . '/storage/' . $homeContent->image_1_sec_3 : null,
                'disc_1_sec_3'       => $homeContent->disc_1_sec_3,
                'image_2_sec_3'      => $homeContent->image_2_sec_3 ? $this->baseUrl . '/storage/' . $homeContent->image_2_sec_3 : null,
                'disc_2_sec_3'       => $homeContent->disc_2_sec_3,
                'image_3_sec_3'      => $homeContent->image_3_sec_3 ? $this->baseUrl . '/storage/' . $homeContent->image_3_sec_3 : null,
                'disc_3_sec_3'       => $homeContent->disc_3_sec_3,
                'image_4_sec_3'      => $homeContent->image_4_sec_3 ? $this->baseUrl . '/storage/' . $homeContent->image_4_sec_3 : null,
                'disc_4_sec_3'       => $homeContent->disc_4_sec_3,
                'image_5_sec_3'      => $homeContent->image_5_sec_3 ? $this->baseUrl . '/storage/' . $homeContent->image_5_sec_3 : null,
                'disc_5_sec_3'       => $homeContent->disc_5_sec_3,
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
            'heading'            => 'required|string|max:255',
            'heading_nxt'        => 'required|string|max:255',
            'description'        => 'required|string',
            'heading_2'          => 'required|string|max:255',
            'Sub_heading_2'      => 'required|string|max:255',
            'description_2'      => 'required|string',
            's_description_1'    => 'required|string',
            's_description_2'    => 'required|string',
            's_description_3'    => 'required|string',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'image_2'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'third_sec_heading'  => 'required|string|max:255',
            'image_1_sec_3'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'disc_1_sec_3'       => 'nullable|string',
            'image_2_sec_3'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'disc_2_sec_3'       => 'nullable|string',
            'image_3_sec_3'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'disc_3_sec_3'       => 'nullable|string',
            'image_4_sec_3'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'disc_4_sec_3'       => 'nullable|string',
            'image_5_sec_3'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'disc_5_sec_3'       => 'nullable|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Handle image uploads if they exist
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('home', 'public') : null;
        $image2Path = $request->hasFile('image_2') ? $request->file('image_2')->store('home', 'public') : null;

        // Save home content details to the database
        $homeContent = HomeContent::create([
            'heading'            => $request->input('heading'),
            'heading_nxt'        => $request->input('heading_nxt'),
            'description'        => $request->input('description'),
            'heading_2'          => $request->input('heading_2'),
            'Sub_heading_2'      => $request->input('Sub_heading_2'),
            'description_2'      => $request->input('description_2'),
            's_description_1'    => $request->input('s_description_1'),
            's_description_2'    => $request->input('s_description_2'),
            's_description_3'    => $request->input('s_description_3'),
            'image'              => $imagePath,
            'image_2'            => $image2Path,
            'third_sec_heading'  => $request->input('third_sec_heading'),
            'image_1_sec_3'      => $request->hasFile('image_1_sec_3') ? $request->file('image_1_sec_3')->store('home', 'public') : null,
            'disc_1_sec_3'       => $request->input('disc_1_sec_3'),
            'image_2_sec_3'      => $request->hasFile('image_2_sec_3') ? $request->file('image_2_sec_3')->store('home', 'public') : null,
            'disc_2_sec_3'       => $request->input('disc_2_sec_3'),
            'image_3_sec_3'      => $request->hasFile('image_3_sec_3') ? $request->file('image_3_sec_3')->store('home', 'public') : null,
            'disc_3_sec_3'       => $request->input('disc_3_sec_3'),
            'image_4_sec_3'      => $request->hasFile('image_4_sec_3') ? $request->file('image_4_sec_3')->store('home', 'public') : null,
            'disc_4_sec_3'       => $request->input('disc_4_sec_3'),
            'image_5_sec_3'      => $request->hasFile('image_5_sec_3') ? $request->file('image_5_sec_3')->store('home', 'public') : null,
            'disc_5_sec_3'       => $request->input('disc_5_sec_3'),
        ]);

        // Return success response
        return response()->json([
            'message' => 'Home content created successfully.',
            'data'    => $homeContent
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Validate request using Validator
        $validator = Validator::make($request->all(), [
            'heading'            => 'required|string|max:255',
            'heading_nxt'        => 'required|string|max:255',
            'description'        => 'required|string',
            'heading_2'          => 'required|string|max:255',
            'Sub_heading_2'      => 'required|string|max:255',
            'description_2'      => 'required|string',
            's_description_1'    => 'required|string',
            's_description_2'    => 'required|string',
            's_description_3'    => 'required|string',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'image_2'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'third_sec_heading'  => 'required|string|max:255',
            'image_1_sec_3'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'disc_1_sec_3'       => 'nullable|string',
            'image_2_sec_3'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'disc_2_sec_3'       => 'nullable|string',
            'image_3_sec_3'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'disc_3_sec_3'       => 'nullable|string',
            'image_4_sec_3'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'disc_4_sec_3'       => 'nullable|string',
            'image_5_sec_3'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'disc_5_sec_3'       => 'nullable|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Find the home content
        $homeContent = HomeContent::find($id);
        if (!$homeContent) {
            return response()->json([
                'message' => 'Content not found.'
            ], 404);
        }

        // Handle image uploads if they exist
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($homeContent->image && Storage::exists('public/' . $homeContent->image)) {
                Storage::delete('public/' . $homeContent->image);
            }
            $homeContent->image = $request->file('image')->store('home', 'public');
        }

        if ($request->hasFile('image_2')) {
            // Delete old image if it exists
            if ($homeContent->image_2 && Storage::exists('public/' . $homeContent->image_2)) {
                Storage::delete('public/' . $homeContent->image_2);
            }
            $homeContent->image_2 = $request->file('image_2')->store('home', 'public');
        }

        // Update home content details
        $homeContent->heading            = $request->input('heading');
        $homeContent->heading_nxt        = $request->input('heading_nxt');
        $homeContent->description        = $request->input('description');
        $homeContent->heading_2          = $request->input('heading_2');
        $homeContent->Sub_heading_2      = $request->input('Sub_heading_2');
        $homeContent->description_2      = $request->input('description_2');
        $homeContent->s_description_1    = $request->input('s_description_1');
        $homeContent->s_description_2    = $request->input('s_description_2');
        $homeContent->s_description_3    = $request->input('s_description_3');
        $homeContent->third_sec_heading  = $request->input('third_sec_heading');
        $homeContent->image_1_sec_3      = $request->hasFile('image_1_sec_3') ? $request->file('image_1_sec_3')->store('home', 'public') : $homeContent->image_1_sec_3;
        $homeContent->disc_1_sec_3       = $request->input('disc_1_sec_3');
        $homeContent->image_2_sec_3      = $request->hasFile('image_2_sec_3') ? $request->file('image_2_sec_3')->store('home', 'public') : $homeContent->image_2_sec_3;
        $homeContent->disc_2_sec_3       = $request->input('disc_2_sec_3');
        $homeContent->image_3_sec_3      = $request->hasFile('image_3_sec_3') ? $request->file('image_3_sec_3')->store('home', 'public') : $homeContent->image_3_sec_3;
        $homeContent->disc_3_sec_3       = $request->input('disc_3_sec_3');
        $homeContent->image_4_sec_3      = $request->hasFile('image_4_sec_3') ? $request->file('image_4_sec_3')->store('home', 'public') : $homeContent->image_4_sec_3;
        $homeContent->disc_4_sec_3       = $request->input('disc_4_sec_3');
        $homeContent->image_5_sec_3      = $request->hasFile('image_5_sec_3') ? $request->file('image_5_sec_3')->store('home', 'public') : $homeContent->image_5_sec_3;
        $homeContent->disc_5_sec_3       = $request->input('disc_5_sec_3');
        $homeContent->save();

        // Return success response
        return response()->json([
            'message' => 'Home content updated successfully.',
            'data'    => $homeContent
        ], 200);
    }

    public function destroy($id)
    {
        // Find the home content
        $homeContent = HomeContent::find($id);
        if (!$homeContent) {
            return response()->json([
                'message' => 'Content not found.'
            ], 404);
        }

        // Delete images if they exist
        if ($homeContent->image && Storage::exists('public/' . $homeContent->image)) {
            Storage::delete('public/' . $homeContent->image);
        }

        if ($homeContent->image_2 && Storage::exists('public/' . $homeContent->image_2)) {
            Storage::delete('public/' . $homeContent->image_2);
        }

        // Delete the home content
        $homeContent->delete();

        // Return success response
        return response()->json([
            'message' => 'Home content deleted successfully.'
        ], 200);
    }
}
