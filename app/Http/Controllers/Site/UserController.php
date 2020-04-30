<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\Lowercase;
use Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   
   public function profile(){   
    $user = Auth::user();
    return view('site.pages.user.profile', compact('user'));

   }

   public function updateProfile(Request $request){

    $user = Auth::user();

    $this->validate($request,[  
        'name' => 'required|string|max:40',
        'address' =>  'required|string|max:191',                      
    ]);

    if($user->is_mobile_verified && $user->is_mobile_verified){      
        $user->name = $request->name;
        $user->address = $request->address;
        $user->save();
        session()->flash('success', 'Your profile information has been updated');
        return redirect()->back();
    }elseif($user->is_mobile_verified){    
        $this->validate($request,[ 
            'email' => 'required|string|email|max:100|unique:users,email',                        
        ]);
        $user->name = $request->name;
        $user->email = $request->email;        
        $user->address = $request->address;
        $user->save();
        session()->flash('success', 'Your profile information has been updated');
        return redirect()->back();
    }elseif($user->is_email_verified){
        $this->validate($request,[                                 
            'mobile' =>  'required|string|max:15|unique:users,mobile',                             
        ]);
        $user->name = $request->name;        
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->save();
        session()->flash('success', 'Your profile information has been updated');
        return redirect()->back();
    }    

   }

   public function changePassword(Request $request){

    $user = Auth::user();
    $validated = request()->validate([
        'password' => 'required|min:8|confirmed',  
        'old_password' => 'required|string|min:8',        
     ]);   
 
     if(Hash::check($request->old_password, $user->password )){
        //updating user password.
        $user->update([
            'password' => Hash::make($request->password),            
        ]);
        session()->flash('success', 'Your password is modified.');
        return redirect()->back();
     }else{
        session()->flash('error', 'Your old password is incorrect.');
        return redirect()->back();
     }
    
   }

}
