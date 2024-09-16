<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactPageModal;
use App\Http\Resources\ContactPageRecource;

class ContactPageApi extends Controller
{
    protected $baseUrl;
    protected $imgUrl;

    public function __construct()
    {
        $this->baseUrl = config('app.api_url');
        $this->imgUrl = config('app.img_url');
    }

    public function index(){
        $contactPage = ContactPageModal::all();
        return response()->json([
            'message' => 'Contacts retrieved successfully',
            'data' => ContactPageRecource::collection($contactPage),
        ], 200);
    }

    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $contactPage = ContactPageModal::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'number' => $request->input('number'),
        ]);

        return response()->json([
            'message' => 'Contact page created successfully',
            'data' => $contactPage,
        ], 201);
    }


    // public function update(Request $request, $id)
    // {
        
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string',
    //     ]);
        

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'errors' => $validator->errors(),
    //         ], 422);
    //     }

    //     $contactPage = ContactPageModal::find($id);


    //     if (!$contactPage) {
    //         return response()->json([
    //             'message' => 'Contact page not found',
    //         ], 404);
    //     }

    //     $contactPage->update([
    //         'name' => $request->input('name'),
    //     ]);

    //     return response()->json([
    //         'message' => 'Contact page updated successfully',
    //         'data' => $contactPage,
    //     ], 200);
    // }


    public function update(Request $request, $id)
    {
        // Log incoming request data
        \Log::info('Incoming Request Data:', $request->all());
        \Log::info('Request Method:', [$request->method()]);
        \Log::info('Request Headers:', $request->headers->all());
    
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'number' => 'required|string',
        ]);
        $contentType = $request->header('Content-Type');

    
        if ($validator->fails()) {
            // Log the validation errors
            \Log::error('Validation errors:', $validator->errors()->toArray());
    
            return response()->json([
                'errors' => $validator->errors(),
                'dd' => $request->all(),
                'errors__' => $contentType,
            ], 422);
        }
    
        // Find the contact page by ID
        $contactPage = ContactPageModal::find($id);
    
        if (!$contactPage) {
            return response()->json([
                'message' => 'Contact page not found',
            ], 404);
        }
    
        // Update the contact page
        $contactPage->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'number' => $request->input('number'),
        ]);
    
        return response()->json([
            'message' => 'Contact page updated successfully',
            'data' => $contactPage,
        ], 200);
    }
    
    
    

    




    public function show($id)
    {
        // Find the existing contact page by ID
        $contactPage = ContactPageModal::find($id);

        // If the contact page is not found, return a 404 response
        if (!$contactPage) {
            return response()->json([
                'message' => 'Contact page not found',
            ], 404);
        }

        // Return the found contact page in the response
        return response()->json([
            'message' => 'Contact page retrieved successfully',
            'data' => new ContactPageRecource($contactPage),
        ], 200);
    }



    public function destroy($id)
    {
        $contactPage = ContactPageModal::find($id);

        if (!$contactPage) {
            return response()->json([
                'message' => 'Contact page not found',
            ], 404);
        }

        $contactPage->delete();

        return response()->json([
            'message' => 'Contact page deleted successfully',
        ], 200);
    }
}
