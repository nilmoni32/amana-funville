<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Auth;

class SalesController extends Controller
{
    
    public function index(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'POS Sales', 'subTitle' => 'Select products for sales and make order placement' ]);       
        return view('admin.sales.index');
    }

    /*
    * Ajax request
    */
    public function getFoods(Request $request){

        $search = $request->search;

        if($search == ''){
            $products = Product::orderby('name','asc')
                                ->select('id','name')
                                ->where('status', 1)
                                ->limit(10)->get();
        }else{
            $products = Product::orderby('name','asc')
                        ->select('id','name')
                        ->where('name', 'like', '%' .$search . '%')
                        ->where('status', 1)
                        ->limit(10)
                        ->get();
        }

        $response = array();
        foreach($products as $product){            
            $response[] = array( "value" => $product->id, "label" => $product->name );            
        }

        return response()->json($response);   
    }

    public function addToSales(Request $request){

        $product = Product::find($request->foodId);
        if($product->discount_price){
            $sale_price = $product->discount_price;
        }else{
            $sale_price = $product->price;
        }

        $sale = new Sale();
        $sale->admin_id = Auth::id(); 
        $sale->product_id = $request->foodId;
        $sale->product_name = $request->foodName;
        $sale->unit_price = $sale_price;
        $sale->product_quantity = 1;
        $sale->save();
              
        return json_encode([ 'status' => 'success', 'foodname' => $sale->product_name , 'price' => $sale->unit_price, 'qty' => $sale->product_quantity ]);
    }


}
