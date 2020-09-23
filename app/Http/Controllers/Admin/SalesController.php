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
use App\Models\Recipe;
use App\Models\Unit;


class SalesController extends Controller
{
    
    use FlashMessages;

    public function index($id){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'POS Sales', 'subTitle' => 'Select products for sales and make order placement' ]);
        return view('admin.sales.index')->with('order_id', $id);
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
        // if no items are added to sale cart
        if(!$this->calculateSubtotal()){
            // setting flash message using trait
           $this->setFlashMessage(' Please add items to the cart', 'error');    
           $this->showFlashMessages(); 
           return redirect()->back();
        }

        //before placement an order we need to check if the food recipe is added of the same food product or not.
        foreach(Sale::where('admin_id', Auth::id())->where('ordersale_id',NULL)->get() as $sale){
            // if recipe is added for the food 
            if(!Recipe::where('product_id', $sale->product_id)->first()){
                 // setting flash message using trait
                $this->setFlashMessage(" You might forget to add '".$sale->product_name."' food recipe that you want to sale", 'error');    
                $this->showFlashMessages(); 
                return redirect()->back();             
            }// redipe is added but recipe ingredients is not added for the food
            elseif(!Recipe::where('product_id', $sale->product_id)->first()->recipeingredients->count()){
                // setting flash message using trait
                $this->setFlashMessage(" You might forget to add '".$sale->product_name."' food recipe ingredients which you want to sale", 'error');    
                $this->showFlashMessages(); 
                return redirect()->back(); 
            }
        }             
      
        $this->validate($request,[  
            'order_tableNo'    => 'required|string|max:10',
            'customer_name'     => 'nullable|string|max:40',             
            'customer_mobile'   => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13',
            'customer_address'  => 'nullable|string|max:191',       
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
        $ord_id = '#'.(10000 + ($ord_id + 1));
        //calculating order grand total        
        $order_total = $this->calculateSubtotal() + ($this->calculateSubtotal() * (config('settings.tax_percentage')/100));
        $order_grand_total = $order_total - $request->order_discount;

        $order = new Ordersale(); // we use order_id as online transaction id.
        $order->admin_id = auth()->user()->id;     
        $order->order_number = $ord_id; 
        $order->discount = $request->order_discount;
        $order->discount_reference = $request->order_discount_reference;
        $order->grand_total = $order_grand_total;  
        $order->order_date = \Carbon\Carbon::now()->toDateTimeString(); 
        $order->payment_method = implode(',', $request->payment_method); // making array to string before saving to database.
        $order->cash_pay = $request->cash_pay;
        $order->card_pay = $request->card_pay;
        $order->mobile_banking_pay = $request->mobile_banking_pay;
        $order->order_tableNo = $request->order_tableNo;      
        $order->customer_name = $request->customer_name;        
        $order->customer_mobile = $request->customer_mobile;
        $order->customer_address = $request->customer_address;
        $order->customer_notes = $request->customer_notes;
        $order->save();
        // when order is placed we set ordersale_id to Sale cart 
        foreach(Sale::where('admin_id', Auth::id())->where('ordersale_id',NULL)->get() as $sale){
            $sale->ordersale_id = $order->id;           
            $sale->save();
        }

         //Inventory Management: We will deduct product quantity and product total cost using product id from ingredient stock. 

         //finding the cart using order id... it may return many sale carts for pos system
         foreach($order->sales as $cart){
            //getting product quantity that user has purchased.
            $cart_product_quantity = $cart->product_quantity;
            //using product id finding the recipe and then finding the ingredients of the recipe
            foreach(Recipe::where('product_id', $cart->product_id)->first()->recipeingredients as $recipeingredient){
                //getting the ingredient.
                $ingredient = $recipeingredient->ingredient;                   
                //Subtracting ingredient total cost from ingredient stock consumed in recipe ingredients. 
                $ingredient->total_price -= ($recipeingredient->ingredient_total_cost * $cart_product_quantity);
                // if ingredient stock unit is equal to recipe ingredients... then we just deduct qty from ingredient stock.
                if($ingredient->measurement_unit == $recipeingredient->measure_unit){
                    $ingredient->total_quantity -= ($recipeingredient->quantity * $cart_product_quantity); 
                }else{
                    // getting unit conversion value from Unit 
                    $unit = Unit::where('smallest_measurement_unit', $recipeingredient->measure_unit)->first();            
                    $unit_conversion = $unit->unit_conversion; 
                    $ingredient->total_quantity -= ($recipeingredient->quantity * $cart_product_quantity/$unit_conversion);
                }
                $ingredient->save();

            }

        }

        // setting flash message using trait
        $this->setFlashMessage(' Order is placed successfully', 'success');    
        $this->showFlashMessages(); 
        //$this->saleInvoice($order->id);
        // view()->share(['pageTitle' => 'POS Sales', 'subTitle' => 'Select products for sales and make order placement' ]);       
        // return view('admin.sales.index')->with('order_id', $order->id);
        return redirect()->route('admin.sales.index', $order->id);   
       
    }    

    public function getMobileNo(Request $request){

        $search = $request->search;
       
        $customers = Ordersale::orderby('customer_name','asc')
                    ->select('customer_name','customer_mobile')
                    ->where('customer_mobile', 'like', '%' .$search . '%')                    
                    ->limit(5)
                    ->get();        

        $response = array();
        foreach($customers as $customer){            
            $response[] = array( "value" => $customer->customer_name, "label" => $customer->customer_mobile
            );            
        }

        return response()->json($response); 
    }

    public function addCustomerInfo(Request $request){
        
        $mobile = $request->mobile;

        $customer = Ordersale::select('customer_name','customer_mobile','customer_address','customer_notes')                    
                    ->where('customer_mobile', 'like', '%' .$mobile . '%')
                    ->get();

        return response()->json($customer); 

    }



}
