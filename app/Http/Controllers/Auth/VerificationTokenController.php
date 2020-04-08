<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Providers\RouteServiceProvider;


class VerificationTokenController extends Controller
{
    public function verifytoken(){
        return view('auth.passwords.otp');
    }

    public function postverifytoken(Request $request){

        $validated = request()->validate([
            'email_token' => 'required',           
            ]);
        //finding the user with email verification code.
        $user = User::where('email_token', $validated['email_token'])->first();
        
        if(!$user)
        {   
            return redirect()->back()->with('error', 'Invalid OTP Number.');
        }
        else{
            $user->update([
                'email_token' => mt_rand(10000,99999),
            ]);
            return redirect()->route('password.reset',[ 'token' => $user->email_token, 'email' => $user->email])->with('success','Please update your password.');
        }       

    }
}
