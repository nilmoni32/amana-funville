<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Crypt;


class VerificationTokenController extends Controller
{
    
      /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    /**
     * verify token for account activation
     */
    public function verify(Request $request)
    {      
        
        $validated = request()->validate([
            'email_token' => 'required',           
            ]);
        //finding the user with email verification code.
        $user = User::where('email_token', $validated['email_token'])->first();

       if($user == null){        
            session()->flash('success', '');   
            session()->flash('error', 'Invalid Verification Code');
        return view('auth.verification');     
       }      

       $user->update([        
        'is_email_verified' => 1,
        'verified_at' => Carbon::now(),
        'email_token' => '',
       ]);
       
       session()->flash('success', 'Your account is activated, you can log in now');
       return redirect()->route('login');

    }
    
    /**
     * Displaying OTP form for reset password
     */
    public function verifytoken(){
        return view('auth.passwords.otp');
    }

    /**
     * post verify OTP for password reset
     */
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
            // for security issue data is encrypted
            $token = Crypt::encryptString($user->email_token);
            
            return redirect()->route('password.reset',[ 'token' => $token, 'email' => $user->email])->with('success','Please update your password.');
        }       

    }
}
