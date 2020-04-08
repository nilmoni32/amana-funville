<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use App\Models\User;



class VerificationController extends Controller
{
    
     /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


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
}
