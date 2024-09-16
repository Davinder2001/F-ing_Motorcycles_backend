<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsOfUse; // Assuming you have a TermsOfUse model
use Validator;
use App\Http\Resources\TermsOfUseResource;

class TermsOfUseController extends Controller
{
    // List all terms of use
    public function index()
    {
        return TermsOfUseResource::collection(TermsOfUse::all());
    }

    // Store a new Terms of Use
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $termsOfUse = TermsOfUse::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Terms of Use created successfully',
            'data' => $termsOfUse
        ]);
    }

    // Show a specific Terms of Use
    public function show($id)
    {
        $termsOfUse = TermsOfUse::find($id);

        if (!$termsOfUse) {
            return response()->json(['status' => false, 'message' => 'Terms of Use not found'], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $termsOfUse
        ]);
    }

    // Update an existing Terms of Use
    public function update(Request $request, $id)
    {
        $termsOfUse = TermsOfUse::find($id);

        if (!$termsOfUse) {
            return response()->json(['status' => false, 'message' => 'Terms of Use not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $termsOfUse->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Terms of Use updated successfully',
            'data' => $termsOfUse
        ]);
    }

    // Delete a Terms of Use
    public function destroy($id)
    {
        $termsOfUse = TermsOfUse::find($id);

        if (!$termsOfUse) {
            return response()->json(['status' => false, 'message' => 'Terms of Use not found'], 404);
        }

        $termsOfUse->delete();

        return response()->json([
            'status' => true,
            'message' => 'Terms of Use deleted successfully'
        ]);
    }
}
