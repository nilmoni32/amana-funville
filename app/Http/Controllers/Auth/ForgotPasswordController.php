<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\OtpMailable;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function postforgot(Request $request){
        
        $validated = request()->validate([
            'email' => 'required|email|exists:users',       
            ]);     
        //finding the user with email verification code.
        $user = User::where('email', $validated['email'])->first();

        if(!$user->is_email_verified){
            return redirect()->back()->with('error', 'User account has not been activated. Please activate first.');
        }
        else{
            //setting the eamil token.
            $user->update([ 
                 'email_token' => mt_rand(10000,99999),                  
                ]);
            
             // sending mail to mailable class OtpMailable for the user with it's email id
            \Mail::to($user->email)->send(new OtpMailable($user));

            return redirect('verifytoken')->with('success', 'Please check your email to get the OTP to reset your password');
        }
        
    }
}
