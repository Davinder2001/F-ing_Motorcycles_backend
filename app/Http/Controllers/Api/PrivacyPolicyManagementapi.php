<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy; // Assuming you have a PrivacyPolicy model
use Validator;
use App\Http\Resources\PrivacyPolicyResource;


class PrivacyPolicyManagementapi extends Controller
{
   
    public function index()
    {
        return PrivacyPolicyResource::collection(PrivacyPolicy::all());

    }

    // Store a new Privacy Policy
    public function store(Request $request)
    {

        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $policy = PrivacyPolicy::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Privacy Policy created successfully',
            'data' => $policy
        ]);
    }

    // Show a specific Privacy Policy
    public function show($id)
    {
        $policy = PrivacyPolicy::find($id);

        if (!$policy) {
            return response()->json(['status' => false, 'message' => 'Privacy Policy not found'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $policy
        ]);
    }

    // Update an existing Privacy Policy
    public function update(Request $request, $id)
    {
        $policy = PrivacyPolicy::find($id);

        if (!$policy) {
            return response()->json(['status' => false, 'message' => 'Privacy Policy not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $policy->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Privacy Policy updated successfully',
            'data' => $policy
        ]);
    }

    // Delete a Privacy Policy
    public function destroy($id)
    {
        $policy = PrivacyPolicy::find($id);

        if (!$policy) {
            return response()->json(['status' => false, 'message' => 'Privacy Policy not found'], 404);
        }

        $policy->delete();

        return response()->json([
            'status' => true,
            'message' => 'Privacy Policy deleted successfully'
        ]);
    }
}
