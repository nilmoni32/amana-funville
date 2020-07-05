<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Ordersale;
use Auth;
use App\Traits\FlashMessages; 

class SalesController extends Controller
{
    
    use FlashMessages;
    public function index(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'POS Sales', 'subTitle' => 'Select products for sales and make order placement' ]); 
      
        return view('admin.sales.index')->with('order_id', 0);
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
        //checking discount price is enabled for this product
        if($product->discount_price){
            $sale_price = $product->discount_price;
        }else{
            $sale_price = $product->price;
        }
        //checking the product whether it is already added to the sale cart, if so we sent the message this product is already added to the cart.
        $sale = Sale::where('admin_id', Auth::id())
                    ->where('product_id', $request->foodId)
                    ->where('ordersale_id', NULL) 
                    ->first();
        if(!is_null($sale)){
            return json_encode([ 'status' => 'info', 'message' => "This food is already added to the cart."  ]);
        }
        else{
            // adding new item to the sale cart
            $sale = new Sale();
            $sale->admin_id = Auth::id(); 
            $sale->product_id = $request->foodId;
            $sale->product_name = $request->foodName;
            $sale->unit_price = $sale_price;
            $sale->product_quantity = 1;
            $sale->save();

            return json_encode([ 'status' => 'success', 'foodname' => $sale->product_name , 'price' => $sale->unit_price, 'qty' => $sale->product_quantity, 'id' => $sale->id , 'sub_total' => $this->calculateSubtotal() ]);
            
        }  
        
        
    }


    public function update(Request $request)
    {  
        $id = $request->sale_id;                
        $sale = Sale::find($id);//primary key id
        $sale->product_quantity = $request->product_quantity;           
        $sale->save();
        
        if($sale->product->discount_price){
                $total_unit_price = $sale->product->discount_price * $sale->product_quantity;
        }else{
                $total_unit_price = $sale->product->price * $sale->product_quantity;
        }
         
        return json_encode([ 'status' => 'success', 'total_unit_price' => $total_unit_price, 'sub_total' => $this->calculateSubtotal() ]);      
    }

    public function destroy(Request $request)
    {
        $sale = Sale::find($request->sale_id);
        if(!is_null($sale)){            
            $sale->delete();
            return json_encode([ 'status' => 'success', 'message' => 'Item is deleted', 'sub_total' => $this->calculateSubtotal() ]); 
        }
        return json_encode(['status' => 'error', 'message' => 'An error is occurred while deleting the cart' ]);
    }  
    
    public function calculateSubtotal(){
        // calculating subtotal
        $total_taka=0.0;
        foreach(Sale::where('admin_id', Auth::id())->where('ordersale_id',NULL)->get() as $sale){      
          
            if($sale->product->discount_price){
                    $total_taka += $sale->product->discount_price * $sale->product_quantity;
            }else{
                    $total_taka += $sale->product->price * $sale->product_quantity;
            }         
        }
        return $total_taka;
    }

    public function orderplace(Request $request){

        if(!$this->calculateSubtotal()){
             // setting flash message using trait
            $this->setFlashMessage(' Please add items to the cart', 'error');    
            $this->showFlashMessages(); 
            return redirect()->back();
        }
      
        $this->validate($request,[  
            'customer_name'     => 'nullable|string|max:40',
            'customer_email'    => 'nullable|string|email|max:100', 
            'customer_phone'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13',       
            'customer_notes'    => 'nullable|string|max:191',             
        ]);

        // finding last order id: we use it for customer order id (customized) for billing purpose
        // it will be false only for the first record.
        if(!Ordersale::orderBy('id', 'desc')->first()){
            $ord_id = 0;
        }
        else{
            $ord_id = Ordersale::orderBy('id', 'desc')->first()->id; 
        }   
        $ord_id = '#'.(1000 + ($ord_id + 1));

        $order = new Ordersale(); // we use order_id as online transaction id.
        $order->admin_id = auth()->user()->id;     
        $order->order_number = $ord_id; 
        $order->grand_total = $this->calculateSubtotal();  
        $order->order_date = \Carbon\Carbon::now()->toDateTimeString();      
        $order->customer_name = $request->customer_name;        
        $order->customer_mobile = $request->customer_phone;
        $order->customer_email = $request->customer_email;
        $order->customer_notes = $request->customer_notes;
        $order->save();
        // when order is placed we set ordersale_id to Sale cart 
        foreach(Sale::where('admin_id', Auth::id())->where('ordersale_id',NULL)->get() as $sale){
            $sale->ordersale_id = $order->id;           
            $sale->save();
        }
        // setting flash message using trait
        $this->setFlashMessage(' Order is placed successfully', 'success');    
        $this->showFlashMessages(); 
        view()->share(['pageTitle' => 'POS Sales', 'subTitle' => 'Select products for sales and make order placement' ]);       
        return view('admin.sales.index')->with('order_id', $order->id);
        
    }

    public function saleInvoice($saleOrder_id){
        dd($saleOrder_id);
    }



}
