<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\VerificationEmail;
use Illuminate\Http\Request;
use App\Rules\Lowercase;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email', new Lowercase],           
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * we are using register method instead of create method so that user is not logged in automatically.
     * they can login after the email verification.
     * @param  array  $data
     * @return \App\User
     */
    protected function register(Request $request)
    {
        // we need to call validator method, if we want to use register method here.
        $this->validator($request->all())->validate();
        $this->validate($request,[                       
            'mobile'               =>  'required|string|max:15|unique:users,mobile',                        
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'mobile' => $request->mobile,
            'email_token' => mt_rand(10000,99999),            
        ]);
        // sending mail to mailable class VerificationEmail for the user with it's email id
        \Mail::to($user->email)->send(new VerificationEmail($user));

        session()->flash('success', 'Please check your email to get the verification code to activate your account');
        return view('auth.verification');

    }

    
}
