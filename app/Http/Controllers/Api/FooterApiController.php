<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Header_footer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class FooterApiController extends Controller
{
    public function index()
    {
        $footer = Header_footer::all();
        return response()->json($footer);
    }
    
    public function store(Request $request)
    {
       
        $validatedData = Validator::make($request->all(), [
            'column_1_heading_1'    =>  'required|string|max:255',
            'column_1_field_1'      =>  'nullable|string|max:255',
            'column_1_field_2'      =>  'nullable|string|max:255',
            'column_1_field_3'      =>  'nullable|string|max:255',
            'column_1_field_4'      =>  'nullable|string|max:255',
            'column_2_heading_1'    =>  'required|string|max:255',
            'column_2_field_1'      =>  'nullable|string|max:255',
            'column_2_field_2'      =>  'nullable|string|max:255',
            'column_2_field_3'      =>  'nullable|string|max:255',
            'column_3_heading_1'    =>  'required|string|max:255',
            'column_3_field_1'      =>  'nullable|string|max:255',
            'column_3_field_2'      =>  'nullable|string|max:255',
            'column_3_field_3'      =>  'nullable|string|max:255',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validatedData->errors()
            ], 401);
        }

        try {
            $footer = Header_footer::create($request->all());

            return response()->json([
                'message' => 'Footer created successfully.',
                'data' => $footer,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Footer creation failed: ' . $e->getMessage());
            return response()->json(['message' => 'Footer creation failed.'], 500);
        }
    }

    public function show(Header_footer $footer)
    {
        return response()->json($footer);
    }

    public function update(Request $request, Header_footer $footer)
    {
        $validatedData = Validator::make($request->all(), [
       
            'column_1_heading_1'    =>  'nullable|string|max:255',
            'column_1_field_1'      =>  'nullable|string|max:255',
            'column_1_field_2'      =>  'nullable|string|max:255',
            'column_1_field_3'      =>  'nullable|string|max:255',
            'column_1_field_4'      =>  'nullable|string|max:255',
            'column_2_heading_1'    =>  'nullable|string|max:255',
            'column_2_field_1'      =>  'nullable|string|max:255',
            'column_2_field_2'      =>  'nullable|string|max:255',
            'column_2_field_3'      =>  'nullable|string|max:255',
            'column_3_heading_1'    =>  'nullable|string|max:255',
            'column_3_field_1'      =>  'nullable|string|max:255',
            'column_3_field_2'      =>  'nullable|string|max:255',
            'column_3_field_3'      =>  'nullable|string|max:255',
        ]);
        // dd($validatedData); 
        if ($validatedData->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validatedData->errors()
            ], 401);
        }

        try {
            $footer->update($request->all());

            return response()->json([
                'message' => 'Footer updated successfully.',
                'data' => $footer,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Footer update failed: ' . $e->getMessage());
            return response()->json(['message' => 'Footer update failed.'], 500);
        }
    }

    public function destroy(Header_footer $footer)
    {
        try {
            $footer->delete();
            return response()->json(['message' => 'Footer deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Footer deletion failed: ' . $e->getMessage());
            return response()->json(['message' => 'Footer deletion failed.'], 500);
        }
    }
}
