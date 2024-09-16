<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsAndConditions; // Assuming you have a TermsAndConditions model
use Validator;
use App\Http\Resources\TermsAndConditionsResource;

class TermsAndConditionsController extends Controller
{
    // List all terms and conditions
    public function index()
    {
        return TermsAndConditionsResource::collection(TermsAndConditions::all());
    }

    // Store a new Terms and Conditions
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $termsAndConditions = TermsAndConditions::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Terms and Conditions created successfully',
            'data' => $termsAndConditions
        ]);
    }

    // Show a specific Terms and Conditions
    public function show($id)
    {
        $termsAndConditions = TermsAndConditions::find($id);

        if (!$termsAndConditions) {
            return response()->json(['status' => false, 'message' => 'Terms and Conditions not found'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $termsAndConditions
        ]);
    }

    // Update an existing Terms and Conditions
    public function update(Request $request, $id)
    {
        $termsAndConditions = TermsAndConditions::find($id);

        if (!$termsAndConditions) {
            return response()->json(['status' => false, 'message' => 'Terms and Conditions not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $termsAndConditions->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Terms and Conditions updated successfully',
            'data' => $termsAndConditions
        ]);
    }

    // Delete Terms and Conditions
    public function destroy($id)
    {
        $termsAndConditions = TermsAndConditions::find($id);

        if (!$termsAndConditions) {
            return response()->json(['status' => false, 'message' => 'Terms and Conditions not found'], 404);
        }

        $termsAndConditions->delete();

        return response()->json([
            'status' => true,
            'message' => 'Terms and Conditions deleted successfully'
        ]);
    }
}
