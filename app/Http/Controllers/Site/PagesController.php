<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * viewing the homepage of funville
     */
    public function index(){
        
        return view('site.pages.homepage');
    }

    public function about(){
        return "about page will be developed soon";
    }
}
