<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Director;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Traits\FlashMessages; 

class DirectorController extends BaseController
{
    use FlashMessages;

    public function index(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'A board of Directors', 'subTitle' => 'List of all Directors']);
        $directors = Director::orderBy('created_at', 'asc')->get();        
        return view('admin.director.index', compact('directors')); 
   }

    public function create(){  
    // Attaching pagetitle and subtitle to view.
    view()->share(['pageTitle' => 'A board of Directors', 'subTitle' => 'Add Director Details' ]);       
    return view('admin.director.create');  
    }

    public function store(Request $request){
        
        $this->validate($request,[
            'name'           => 'required|string|max:255',            
            'mobile'         => 'required|regex:/(01)[3-9]{1}(\d){8}/|max:11|unique:directors,mobile',
            'email'          => 'nullable|string|email|max:191|unique:directors,email',
            'designation'    => 'nullable|string|max:255', 
            'discount_slab_percentage' => 'required|digits_between:1,2',                                 
        ]);

        $director = Director::create([
            'name' =>   $request->name,
            'mobile' => $request->mobile,
            'email' =>  $request->email, 
            'designation' =>  $request->designation, 
            'discount_slab_percentage' =>  $request->discount_slab_percentage,            
        ]);
        
        if($director){         

            // setting flash message using trait
            $this->setFlashMessage(' New Director details is added successfully', 'success');    
            $this->showFlashMessages();
            return redirect()->route('admin.board.directors.index');
        }else{
            return $this->responseRedirectBack(' Error occurred while adding Director details.' ,'error', false, false);    
        }
    }

    public function edit($id){
        $director = Director::find($id);
        view()->share(['pageTitle' => 'A board of Directors', 'subTitle' => 'Edit Director Details']);
        return view('admin.director.edit', compact('director'));   
    }

    public function update(Request $request){

        $this->validate($request,[
            'name'           => 'required|string|max:255',            
            'mobile'         => 'required|regex:/(01)[3-9]{1}(\d){8}/|max:11',
            'email'          => 'nullable|string|email|max:191',
            'designation'    => 'nullable|string|max:255', 
            'discount_slab_percentage' => 'required|digits_between:1,2',
        ]);
        
        $director = Director::find($request->id);            
        $director->name = $request->name;
        $director->mobile = $request->mobile;
        $director->email = $request->email;
        $director->designation = $request->designation;
        $director->discount_slab_percentage = $request->discount_slab_percentage;
        $director->save();

        // setting flash message using trait
        $this->setFlashMessage(' Director details is updated successfully', 'success');    
        $this->showFlashMessages();
        return redirect()->route('admin.board.directors.index');
    }

    public function delete($id){        
        $director = Director::find($id); 
        $director->delete();
        if(!$director){
            return  $this->responseRedirectBack(' Error occurred while deleting the Director details.', 'error', true, true);
         }
        $this->setFlashMessage(' The Director Details is deleted successfully', 'success');    
        $this->showFlashMessages();
        return redirect()->route('admin.board.directors.index');
    }

  
}
