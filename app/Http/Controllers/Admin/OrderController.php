<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\BaseController;
use PDF;
use Carbon\Carbon;
use DateTime;
use App\Models\Cart;
use App\Models\Recipe;
use App\Models\Unit;
use Auth;

class OrderController extends BaseController
{
    public function index(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Orders', 'subTitle' => 'List of all orders' ]);
        $orders = Order::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }
    public function edit($id){
        // Attaching pagetitle and subtitle to view.          
        $order = Order::where('id', $id)->first();
        view()->share(['pageTitle' => 'Orders', 'subTitle' => 'Order No: '.$order->order_number ]);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request){
        //before placement an order status to delivered we need to check if the food recipe is added of the same food product or not.
        if($request->status == 'delivered'){
        foreach(Cart::where('order_id', $request->id)->get() as $cart){
            if(!Recipe::where('product_id', $cart->product_id)->first()){
                 // setting flash message using trait
                $this->setFlashMessage(" You might forget to add '". $cart->product->name ."' food recipe which you want to sale", 'error');    
                $this->showFlashMessages(); 
                return redirect()->back();             
                }elseif(!Recipe::where('product_id', $cart->product_id)->first()->recipeingredients->count()){
                     // setting flash message using trait
                $this->setFlashMessage(" You might forget to add '". $cart->product->name ."' food recipe ingredients which you want to sale", 'error');    
                $this->showFlashMessages(); 
                return redirect()->back(); 
                }
            }
        }
        
        $order = Order::where('id', $request->id)->first(); 
        if($request->status == 'cancel')
        {
            // when order is canceled by user or after checkout, we need to set order_cancel to 1 in the cart table for that cart 
            // we need this for reporting purpose.       
            foreach(Cart::where('order_id', $request->id)->get() as $cart){
                $cart->order_cancel = 1;
                $cart->save();           
            } 
        }
       
        $order->status = $request->status;
        $order->save(); 
        //Inventory Management: When order status is changed to delivered, we will deduct product quantity and product total cost using product id from ingredient stock. 
        if($order->status == 'delivered'){
            //finding the cart using order id... it may return many carts
            foreach($order->carts as $cart){
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

        }     
        return $this->responseRedirectBack(' Order status is updated successfully' ,'success', false, false); 
    }

    public function search(Request $request){
         // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Orders', 'subTitle' => 'List of Search orders' ]);
        $search = trim($request->search); // getting the search key

        if($search == 'paid' || $search == 'Paid'){
            $search = 1; 
            $orders = Order::Where('payment_status', 'like', '%'.$search.'%')->paginate(15);  
            return view('admin.orders.index', compact('orders'));        
        }elseif($search == 'Not paid' || $search == 'not paid'){
            $search = 0;
            $orders = Order::Where('payment_status', 'like', '%'.$search.'%')->paginate(15);
            return view('admin.orders.index', compact('orders'));
        }  

       // for other search criteria.
        $orders = Order::orWhere('order_number', 'like', '%'.$search.'%')
        ->orWhere('order_date', 'like', '%'. ($this->validateDate($search) ? Carbon::createFromFormat('d-m-Y', $search)->format('Y-m-d') : $search).'%')                  
        ->orWhere('grand_total', 'like', '%'.$search.'%')
        ->orWhere('status', 'like', '%'.$search.'%')
        ->orWhere('payment_method', 'like', '%'.$search.'%')->paginate(15);         

        return view('admin.orders.index', compact('orders'));
    }

    public function generateInvoice($id){
        $order = Order::where('id', $id)->first();
        $pdf = PDF::loadView('admin.orders.invoice', compact('order'));
        return $pdf->stream('invoice.pdf');
        
        //return view('admin.orders.invoice', compact('order'));
    }


    public function validateDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}
