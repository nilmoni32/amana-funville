<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zone;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductAttribute;
use App\Models\District;
use Session;
use Auth;
use App\Events\OrderPlaced;

session_start();

class CheckoutController extends Controller
{
    public function getCheckout(){
        return view('site.pages.checkout');
    }

    public function getZones($id){    
        $zones = Zone::where('district_id',$id)->where('status', 1 )->pluck("name","id");
        return json_encode($zones);
    }

    public function getUserAddress(){     
        // when user checked user default address
        return json_encode([ 'status' => 'success', 'address' => auth()->user()->address]);
    }

    public function placeOrder(Request $request){ 
        
    $this->validate($request,[  
        'name' => 'required|string|max:40',
        'email' => 'nullable|string|email|max:100,', 
        'phone_no' =>  'required|regex:/(01)[3-9]{1}(\d){8}/|max:13',       
        'address_txt' =>  'required|string|max:191', 
        'district' => 'required|string',
        'zone' => 'required|string',
    ]);
    
    $shipping_cost = (float)config('settings.delivery_charge');    
    $sub_total = Cart::calculateSubtotal();
    $vat = $sub_total * (config('settings.tax_percentage')/100);
    $grand_total = $sub_total + $shipping_cost + $vat;

    // finding last order id: we use it for customer order id (customized) for billing purpose
    // it will be false only for the first record.
    if(!Order::orderBy('id', 'desc')->first()){
        $ord_id = 0;
    }
    else{
        $ord_id = Order::orderBy('id', 'desc')->first()->id; 
    }   
    $ord_id = '#'.(100000 + ($ord_id + 1));

    $order = new Order(); // we use order_id as online transaction id.
    $order->user_id = auth()->user()->id;     
    $order->order_number = $ord_id; 
    $order->payment_method = 'Cash';
    $order->bank_tran_id = 'N/A';
    $order->status = 'pending';
    $order->payment_status = 0;
    $order->grand_total = $grand_total;
    $order->item_count = Cart::totalItems();
    $order->name = $request->name;
    $order->email = $request->email;
    $order->phone_no = $request->phone_no;
    $order->address = $request->address_txt;
    $order->district = District::where('id', $request->district)->first()->name;
    $order->zone = Zone::where('id',  $request->zone)->first()->name;
    $order->order_date = \Carbon\Carbon::now()->toDateTimeString();
    $order->delivery_date = $request->delivery_timings;
    $order->save();
    // when order is placed we set order_id to cart for that cart and set cart ip_address to null as it is used
    // for guest only.
    foreach(Cart::totalCarts() as $cart){
        $cart->order_id = $order->id;
        $cart->ip_address = NULL;       
        $cart->save();
    }

    // An event is triggered to notify backend user for an new order placement
    event(new OrderPlaced($order->order_number));
   
    return redirect()->route('checkout.payment', $order->id);

    }

    public function checkoutPayment($id){
        //getting the order for the respective user.
        $order = Order::where('id', $id)->first();        
        return view('site.pages.payment', compact('order'));
    }

    public function cancelOrder($id){
        //getting the order for the respective user.
        $order = Order::where('id', $id)->first();
        $order->status = "cancel";
        $order->payment_method = 'None';
        $order->error = 'Cancelled by user';
        $order->save();
        // when order is canceled by user after checkout, we need to set order_cancel to 1 in the cart table for that cart 
        // we need this for reporting purpose.       
        foreach(Cart::where('user_id', Auth::id())->where('order_id', $order->id)->get() as $cart){
            $cart->order_cancel = 1;
            $cart->save();
        }
        
        // // An event is triggered to notify backend user for an new order placement
        // event(new OrderPlaced($order->order_number));
        
        if(session()->has('error') && session()->get('error') !== ''){
            session()->flash('error', '');
        }
        session()->flash('error', 'The Order has been Canceled by user.');
        return view('site.pages.paynotify', compact('order'));
    }

    public function cashOrder($id){
         //getting the order for the respective user.
        $order = Order::where('id', $id)->first();        
        $order->payment_method = 'Cash';
        $order->bank_tran_id = 'N/A';
        $order->save();

        // // An event is triggered to notify backend user for an new order placement
        // event(new OrderPlaced($order->order_number));

        if(session()->has('success') && session()->get('success') !== ''){
            session()->flash('success', '');
        }
        session()->flash('success', 'Thank you for your recent order from our Funville restaurant. Your shipment is on its way!');
        return view('site.pages.paynotify', compact('order'));
    }   

   /**
    * SSlCommerz integration
    */
    public function orderPayment($id){

        $order = Order::find($id);

        $post_data = array();
        $post_data['total_amount'] = $order->grand_total; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $order->id; // tran_id must be unique

        #Start to save these value  in session to pick in success page.
        $_SESSION['tran_id']=$post_data['tran_id'];
        #End to save these value  in session to pick in success page.

        $server_name=request()->root()."/";
        $post_data['success_url'] =  $server_name . "checkout/order/success";     
        $post_data['fail_url'] = $server_name . "checkout/order/fail";
        $post_data['cancel_url'] = $server_name . "checkout/order/cancel";

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $order->name;
        $post_data['cus_email'] = $order->email;
        $post_data['cus_add1'] = $order->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $order->phone_no;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "testamanamkhy";
        $post_data['ship_add1 '] = "";
        $post_data['ship_add2'] = "";
        $post_data['ship_city'] = "";
        $post_data['ship_state'] = "";
        $post_data['ship_postcode'] = "";
        $post_data['ship_country'] = "Bangladesh";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";
        

        $sslc = new SSLCommerz();
        $payment_options = $sslc->initiate($post_data, false);

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }   
    }
    public function order_success(Request $request){
        // Auth::user() returns an instance of the authenticated user.     
        $user = Auth::user();
        $sslc = new SSLCommerz();
       
        $tran_id = $_SESSION['tran_id'];        
        $order = Order::find($tran_id);        
        if($request->status == "VALID"){            
            $order->payment_status = 1; // payment = 1 means paid.
            $order->payment_method = $request->card_type; // specify the card
          
            $order->tran_date = $request->tran_date;
            $order->tran_id = $tran_id;
            $order->amount = $request->amount;
            $order->store_amount = $request->store_amount; 
            $order->bank_tran_id = $request->bank_tran_id;
            $order->currency_type = $request->currency_type;
            $order->currency_amount = $request->currency_amount;
            $order->card_no = $request->card_no;
            $order->card_brand = $request->card_brand;
            $order->card_issuer = $request->card_issuer;

            $order->save();  
            //  // An event is triggered to notify backend user for an new order placement
            // event(new OrderPlaced($order->order_number));          
        } 
        if(session()->has('success') && session()->get('success') !== ''){
            session()->flash('success', '');
        }
        session()->flash('success', 'The payment corresponding to the order has received and your shipment is on its way!');       
        return view('site.pages.paynotify', compact('order'));
    }
    public function order_fail(Request $request){              
        $user = Auth::user();
        $sslc = new SSLCommerz();
        $tran_id = $_SESSION['tran_id'];
        $order = Order::find($tran_id);
        if($request->status == "FAILED"){
            $order->status = 'cancel';
            $order->payment_method = 'Failed';
            $order->error = $request->error; 

            $order->tran_date = $request->tran_date;
            $order->tran_id = $tran_id;
            $order->amount = $request->amount;            
            $order->bank_tran_id = $request->bank_tran_id;
            $order->currency_type = $request->currency_type;
            $order->currency_amount = $request->currency_amount;
            $order->card_no = $request->card_no;
            $order->card_brand = $request->card_brand;
            $order->card_issuer = $request->card_issuer;

            $order->save(); 
            // // An event is triggered to notify backend user for an new order placement
            // event(new OrderPlaced($order->order_number));             
        }
        if(session()->has('error') && session()->get('error') !== ''){
            session()->flash('error', '');
        }
        session()->flash('error', 'Sorry!! the payment corresponding to the order has failed.');
        return view('site.pages.paynotify', compact('order'));
    }
    public function order_cancel(Request $request){        
        $user = Auth::user();
        $sslc = new SSLCommerz();
        $tran_id = $_SESSION['tran_id'];
        $order = Order::find($tran_id);
        if($request->status == "CANCELLED"){
            $order->status = 'cancel';
            $order->payment_method = 'None'; 
            $order->error = $request->error; 

            $order->tran_date = $request->tran_date;
            $order->tran_id = $tran_id;
            $order->amount = $request->amount;
            $order->currency_type = $request->currency_type;
            $order->currency_amount = $request->currency_amount;

            $order->save();
            // // An event is triggered to notify backend user for an new order placement
            // event(new OrderPlaced($order->order_number));

            // when order is canceled by user after checkout, we need to set order_cancel to 1 in the cart table for that cart 
            // we need this for reporting purpose.       
            foreach(Cart::where('user_id', Auth::id())->where('order_id', $order->id)->get() as $cart){
                $cart->order_cancel = 1;
                $cart->save();
            }
           
        }
        if(session()->has('error') && session()->get('error') !== ''){
            session()->flash('error', '');
        }
        session()->flash('error', 'The payment corresponding to the order has been canceled.');
        return view('site.pages.paynotify', compact('order'));        
    }
}
