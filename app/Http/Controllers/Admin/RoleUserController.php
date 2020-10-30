<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Admin;
use App\Models\Role;

class RoleUserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Funville Users', 'subTitle' => 'List of Funville users and roles' ]);
        // getting all admin users
        $admins = Admin::all();
        return view('admin.user.index', compact('admins'));
    }    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Funville Users', 'subTitle' => 'List of Funville users and roles' ]);        
        $admin = Admin::where('id', $id)->first();
        return view('admin.user.role', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {           
        // finding the admin user 
        $admin = Admin::where('id', $request->id)->first();
        // new roles are updated at pivot table using sync that accepts an array roles[]
        $admin->roles()->sync($request->roles);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if($admin->save()){
            // setting flash message using trait
            $this->setFlashMessage(' User account is updated successfully', 'success');    
            $this->showFlashMessages();
             // getting all admin users
             $admins = Admin::all();
            // Attaching pagetitle and subtitle to view.
            view()->share(['pageTitle' => 'Funville Users', 'subTitle' => 'List of Funville users and roles' ]); 
            return view('admin.user.index', compact('admins'));

        }else{
            return $this->responseRedirectBack(' There was an error while updating the user account' ,'error', false, false); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //finding the user
        $admin = Admin::where('id', $id)->first();
        // Detach all roles from the user...
        $admin->roles()->detach();
        //delete the user.       
        if($admin->delete()){
             // setting flash message using trait
             $this->setFlashMessage(' User account is deleted successfully', 'success');    
             $this->showFlashMessages();
              // getting all admin users
              $admins = Admin::all();
             // Attaching pagetitle and subtitle to view.
             view()->share(['pageTitle' => 'Funville Users', 'subTitle' => 'List of Funville users and roles' ]); 
             return view('admin.user.index', compact('admins'));

        }else{
            return $this->responseRedirectBack(' There was an error while deleting the user account' ,'error', false, false); 
        }

    }
}
