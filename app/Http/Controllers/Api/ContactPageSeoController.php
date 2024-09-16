<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactPageSeo;
use Validator;

class ContactPageSeoController extends Controller
{
    // Get the SEO details for the contact page
    public function index()
    {
        $contactPage = ContactPageSeo::first();
        if ($contactPage) {
            return response()->json([
                'status' => true,
                'data' => $contactPage
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Contact Page not found'
            ], 404);
        }
    }

    // Store or update SEO details for the contact page
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $contactPage = ContactPageSeo::first();

        if ($contactPage) {
            // Update existing contact page
            $contactPage->update($request->only(['seo_title', 'seo_description', 'seo_keywords']));
        } else {
            // Create new contact page
            $contactPage = ContactPageSeo::create($request->only(['seo_title', 'seo_description', 'seo_keywords']));
        }

        return response()->json([
            'status' => true,
            'message' => $contactPage ? 'Contact Page updated successfully' : 'Contact Page created successfully',
            'data' => $contactPage
        ]);
    }
}
