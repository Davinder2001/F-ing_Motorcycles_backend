<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Http\Resources\EnquiryResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnquiryReceived;
use App\Mail\UserConfirmation;

class FormEnquiryController extends Controller
{
    /**
     * Display a listing of enquiries.
     */
    public function index()
    {
        $enquiries = Enquiry::all(); // Get all enquiries

        // Use EnquiryResource to structure the response
        return EnquiryResource::collection($enquiries);
    }

    /**
     * Store a new enquiry.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'interestedIn' => 'required|string|max:255',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $formData = Enquiry::create($request->all());

        // Send email to admin
        Mail::to('panku102001@gmail.com')->send(new EnquiryReceived($formData));

        // Send email to user
        Mail::to($request->email)->send(new UserConfirmation($formData));

        // Use EnquiryResource for structured response
        return new EnquiryResource($formData);
    }

    /**
     * Display a specific enquiry.
     */
    public function show($id)
    {
        $enquiry = Enquiry::find($id);

        if (!$enquiry) {
            return response()->json([
                'status' => false,
                'message' => 'Enquiry not found'
            ], 404);
        }

        // Use EnquiryResource to format the response
        return new EnquiryResource($enquiry);
    }
}

