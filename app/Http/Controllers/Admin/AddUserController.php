<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Traits\FlashMessages; 
use App\Models\Role;

class AddUserController extends BaseController
{
    
    use FlashMessages;
    /**
     * Show the Admin add user form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAddUserForm()
    {
         // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Add User', 'subTitle' => 'Add User Registeration Form' ]);
        return view('admin.user.register');
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
            'email' => ['required', 'string', 'email', 'max:191', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function saveUser(Request $request){
        
        // we need to call validator method, to validate the data.
        $this->validator($request->all())->validate();      

        $user = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),                  
        ]);
       

        if($user){
            // assigning default role: 'user' to the user when created. using attach()
            $role = Role::select('id')->where('name', 'user')->first();        
            $user->roles()->attach($role);

            // setting flash message using trait
            $this->setFlashMessage('User account is created successfully', 'success');    
            $this->showFlashMessages(); 

            // Attaching pagetitle and subtitle to view.
            view()->share(['pageTitle' => 'Funville Users', 'subTitle' => 'List of Funville users and roles' ]); 

            // getting all admin users
            $admins = Admin::all();
            return view('admin.user.index', compact('admins'));
           
        }else{
            return $this->responseRedirectBack(' There was an error while registering the user' ,'error', false, false);    
        }
   
    }


}
