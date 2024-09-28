<?php

namespace App\Http\Controllers;

use App\Helpar\JWTToken;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function UserRegister(Request $request)
    {
        try {
            User::create([
                'firstName'=>$request->input('firstName'),
                'lastName'=>$request->input('lastName'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
                'password'=>$request->input('password'),
            ]);
            return response()->json([
                'status'=>'success',
                'message'=>'User Registration successfully'
            ],200);
        }
        catch (Exception $e) {
            return response()->json([
                'status'=>'Failed',
                'message'=>'User Registration Failed'
            ],400);
        }
    }

    function UserLogin(Request $request){
        $count=user::where('email','=',$request->input('email'))
                     ->where('password','=',$request->input('password'))
                     ->count();

        if($count==1){
            $token=JWTToken::CreateToken($request->input('email'));
            return response()->json([
                'status'=>'success',
                'token'=>$token,
                'message'=>'User Login successfully'
            ],200);
        }
        else{
            return response()->json([
                'status'=>'Failed',
                'message'=>'unauthorized'
            ],200);
        }
    }

}
