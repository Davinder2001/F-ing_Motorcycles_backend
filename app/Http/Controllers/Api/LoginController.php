<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

   

    // Login controller
    public function login(Request $request){


        try{
            
            // dd('sasasas');
            $validateAdmin = Validator::make($request->all(),
                        [
                'email'     => 'required',
                'password'  => 'required'
            ]);

            if($validateAdmin->fails()){
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validation error',
                    'errors'    => $validateAdmin->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status'    => false,
                    'message'   => 'Email and password dose not match',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            return response()->json([
                'status'    => true,
                'message'   => 'Admin loggd in',
                'token'     => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
            
        }catch(\Throwable $th){
            return response()->json([
                'status'    => false,
                'message'   => $th->getMessage()
            ], 500);
        }
    }


    // Show dashboard controller
    public function showDashboard(){
        $adminDashboard = auth()->user();
        return response()->json([
            'status'    => true,
            'message'   => 'Dashboard',
            'token'     => $adminDashboard,
            'id'      => auth()->user()->id
        ], 200);
    }

    

    // Logout controller    
    public function logout(){


        // dd('Reach controller');

        auth()->user()->tokens()->delete();
        return response()->json([
            'status'    => true,
            'message'   => 'User Logged Out',
            'data'      => []
        ], 200);
    }












 // Register Controller
    // public function registerAdmin(Request $request){
      
      
    //     try{
        
    //       $validateAdmin = Validator::make($request->all(),
    //           [
    //               'name'      => 'required',
    //               'email'     => 'required',
    //               'password'  => 'required'
    //           ]);
    //           if($validateAdmin->fails()){
    //               return response()->json([
    //                   'status'    => false,
    //                   'message'   => 'Validation error',
    //                   'errors'    => $validateAdmin->errors()
    //               ], 401);
    //           }
    //           $user = User::create([
    //               'name'      => $request->name,
    //               'email'     => $request->email,
    //               'password'  => $request->password,
    //           ]);
    //           return response()->json([
    //               'status'    => true,
    //               'message'   => 'Admin created',
    //               'token'     => $user->createToken("API TOKEN")->plainTextToken
    //           ], 200);
    //       }catch(\Throwable $th){
    //           return response()->json([
    //               'status'    => false,
    //               'message'   => $th->getMessage(),
    //           ], 500);
    //       }
    //   }




}
