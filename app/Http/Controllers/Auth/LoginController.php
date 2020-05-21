<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Mail\VerificationEmail;
use Illuminate\Support\Str;
use App\Models\Cart;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * we are overwriting the login function here which is defined in Illuminate\Foundation\Auth\AuthenticatesUsers;
     */
    public function login(Request $request)
    {
        $validated = request()->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            ]);

        // find user by this email.
        $user = User::where('email', $validated['email'])->first();

        if(!is_null($user)){ // if user is exists.

            // if user email_verification status true, only then user is allowed to access his account.
            if($user->is_token_verified){               
                // checking the default laravel gaurd for user ( web  in config/auth )
                // if user email & password is okay then we redirect to the intended homepage.
                if(Auth::guard('web')->attempt(['email' => $validated['email'], 'password' => $validated['password'] ], $request->get('remember') )) {              
                        
                        /**
                        * when guest add items to cart and then he is logged in then we need to set that user id to cart
                        * so that he can see the recently added products in the cart after sign in.
                        */
                        Cart::guestAuthenticatedCart();
                        // here intended method is used to redirect the homepage is requested by user after successful login.
                        return redirect()->intended();
                }
                else{                   
                    return redirect()->back()->with('error','Invalid password. Please try again!');             
                } 

            }
            else{
                
                // if user exists but email verification status is not 1
                // generating a token number for that user and send it for verify.
                if(is_null($user->is_token_verified)){
                    $user->update([ 
                        'verify_token' =>  mt_rand(10000,99999),            
                    ]);
                }
                // we send him token again via mailable class
                \Mail::to($user->email)->send(new VerificationEmail($user)); 
                 // sending token to phone_number 
                SendCode::sendCode($user->phone_number, $user->verify_token);

                if(session()->has('success') && session()->get('success') !== ''){
                    session()->flash('success', '');
                }
                session()->flash('success', 'A new verification code has sent to you.. Please check mail or Phone to activate your account.');
                return view('auth.verification');
                }   
        
        }  
        else{
             // if the user has no account then             
             return redirect()->back()->with('error','Sorry!! Please Register and starts less than a minute.');             
        }      
        

    }



}
