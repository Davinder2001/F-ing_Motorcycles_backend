<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {

        $validatedData = Validator::make($request->all(),
         [
            'name' => 'required|string|max:255',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'category_image' => 'nullable|image|mimes:jpg,png,jpeg|max:20480',
        ]);


        if($validatedData->fails()){
            return response()->json([
                'status'    => false,
                'message'   => 'Validation error',
                'errors'    => $validatedData->errors()
            ], 401);
        }


        $imagePath = $this->handleImageUpload($request, null);  

        try {
            $category = Category::create([
                'name' => $request->name,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'category_image' => $imagePath,
            ]);
            

            return response()->json([
                'message' => 'Category created successfully.',
                'data' => new CategoryResource($category),
            ], 201);

        } catch (\Exception $e) {
            Log::error('Category creation failed: ' . $e->getMessage());
            return response()->json(['message' => 'Category creation failed.'], 500);
        }
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = Validator::make($request->all(),
        [
           'name'               =>  'required|string|max:255',
           'short_description'  =>  'required|string',
           'long_description'   =>  'required|string',
           'category_image'     =>  'nullable|image|mimes:jpg,png,jpeg|max:20480',
       ]);


       if($validatedData->fails()){
        return response()->json([
            'status'    => false,
            'message'   => 'Validation error',
            'errors'    => $validatedData->errors()
        ], 401);
    }
    
        $imagePath = $this->handleImageUpload($request, $category->category_image);

        try {

            $category->update([
                'name'              => $request->name,
                'short_description' => $request->short_description,
                'long_description'  => $request->long_description,
                'category_image'    => $imagePath,
            ]);

            return response()->json([
                'message' => 'Category updated successfully.',
                'data' => new CategoryResource($category),
            ], 200);

        } catch (\Exception $e) {
            Log::error('Category update failed: ' . $e->getMessage());
            return response()->json(['message' => 'Category update failed.'], 500);
        }
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        try {
            if ($category->category_image) {
                Storage::disk('public')->delete($category->category_image);
            }
            $category->delete();

            return response()->json(['message' => 'Category deleted successfully.'], 200);

        } catch (\Exception $e) {
            Log::error('Category deletion failed: ' . $e->getMessage());
            return response()->json(['message' => 'Category deletion failed.'], 500);
        }
    }

    private function handleImageUpload(Request $request, $existingImagePath)
    {
        if ($request->hasFile('category_image')) {
            if ($existingImagePath) {
                Storage::disk('public')->delete($existingImagePath);
            }

            try {
                return $request->file('category_image')->store('category_images', 'public');
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage());
                throw new \Exception('The category image failed to upload.');
            }
        }

        return $existingImagePath;
    }
}
