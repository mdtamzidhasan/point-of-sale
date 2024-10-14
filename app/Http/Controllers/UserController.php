<?php

namespace App\Http\Controllers;

use App\Helpar\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;


class UserController extends Controller
{
    function LoginPage():view{
        return view('pages.auth.login-page');
    }

    function RegistrationPage():view
    {
        return view('pages.auth.registration-page');
    }

    function SendOtpPage():view{
        return view('pages.auth.send-otp-page');
    }

    function VerifyOTPPage():view{
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage():view{
        return view('pages.auth.reset-pass-page');
    }

    function DashboardPage():View{
        return view('pages.dashboard.dashboard-page');
    }



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
        $count=User::where('email','=',$request->input('email'))
                     ->where('password','=',$request->input('password'))
                     ->count();

        if($count==1){
            $token=JWTToken::CreateToken($request->input('email'));
            return response()->json([
                'status'=>'success',
                'token'=>$token,
                'message'=>'User Login successfully'
            ],200)->cookie('token',$token,60*24*30);
        }
        else{
            return response()->json([
                'status'=>'Failed',
                'message'=>'unauthorized'
            ],200);
        }
    }


    function SendOTPCode(Request $request){
        $email=$request->input('email');
        $otp=rand(1000,9999);
        $count=User::where('email','=',$email)->count();

        if($count==1){
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email','=',$email)->update(['otp'=>$otp]);
        }
        else{
            return response()->json([
                'status'=>'Failed',
                'message'=>'unauthorized'
            ],200);
        }
    }

    function VerifyOTP(Request $request){
        $email=$request->input('email');
        $otp=$request->input('otp');
        $count=User::where('email','=',$email)
            ->where('otp','=',$otp)
            ->count();

        if($count==1){
            User::where('email','=',$email)->update(['otp'=>null]);

            $token=JWTToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                'status'=>'success',
                'message'=>'OTP Verification successfully',
            ],200)->cookie('token',$token,60*24*30);
        }
        else{
            return response()->json([
                'status'=>'Failed',
                'message'=>'unauthorized'
            ],200);
        }
    }

    function ResetPassword(Request $request)
    {
        try {
            $email=$request->header('email');
            $password=$request->input('password');
            user::where('email','=',$email)->update(['password'=>$password]);
            return response()->json([
                'status'=>'success',
                'message'=>'Password reset successfully'
            ],200);
        }
        catch (Exception $e) {
            return response()->json([
                'status'=>'Failed',
                'message'=>'unauthorized'
            ],200);
        }
    }





}
