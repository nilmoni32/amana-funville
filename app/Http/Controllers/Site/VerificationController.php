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


    public function VerifyEmail($token = null)
    {
       
        if($token == null) {

    		session()->flash('errors', 'Invalid Login attempt');

    		return redirect()->route('login');

    	}

       $user = User::where('email_verification_token',$token)->first();       

       if($user == null ){

       	session()->flash('errors', 'Invalid Login attempt');

        return redirect()->route('login');

       }

       $user->update([
        
        'email_verification' => 1,
        'email_verified_at' => Carbon::now(),
        'email_verification_token' => '',

       ]);
       
       	session()->flash('success', 'Your account is activated, you can log in now');

        return redirect()->route('login');

    }
}
