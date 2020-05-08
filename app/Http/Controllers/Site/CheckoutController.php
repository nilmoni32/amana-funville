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
        'email' => 'required|string|email|max:100,', 
        'phone_no' =>  'required|string|max:15,',
        'address_txt' =>  'required|string|max:191', 
        'district' => 'required|string',
        'zone' => 'required|string',
    ]);
    
    $shipping_cost = (float)config('settings.delivery_charge');
    $sub_total = Cart::calculateSubtotal();
    $grand_total = $sub_total + $shipping_cost;

    $order = new Order();
    $order->user_id = auth()->user()->id;
    // since the random number can be duplicate, we use order_id as transaction id.
    $order->order_number = 'ORD-'.strtoupper(uniqid()); 
    $order->payment_method = 'cash';
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
    $order->order_date = \Carbon\Carbon::now()->toDateString();
    $order->delivery_date = $request->delivery_timings;
    $order->save();

    foreach(Cart::totalCarts() as $cart){
        $cart->order_id = $order->id;
        $cart->save();
    }
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
        $order->status = "decline";
        $order->payment_method = 'Cancelled by User';
        $order->save();
        session()->flash('error', 'The Order has been Canceled by user.');
        return view('site.pages.paynotify', compact('order'));
    }

    public function cashOrder($id){
         //getting the order for the respective user.
         $order = Order::where('id', $id)->first();
         $order->status = "processing";
         $order->payment_method = 'cash';
         $order->save();
         session()->flash('success', 'Thank you for your recent order from our Funville shop. Your shipment is on its way!');
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
       // dd($request->all());
        $user = Auth::user();
        $sslc = new SSLCommerz();
        $tran_id = $_SESSION['tran_id'];        
        $order = Order::find($tran_id);        
        if($request->status == "VALID"){
            $order->payment_status = 1; // payment = 1 means paid.
            $order->payment_method = $request->card_type; // specify the card 
            $order->status = 'processing';
            $order->save();
            session()->flash('success', 'The payment corresponding to the order has received and your shipment is on its way!');       
            return view('site.pages.paynotify', compact('order'));
        }        
        session()->flash('error', 'The payment corresponding to the order has failed.');       
        return view('site.pages.paynotify', compact('order'));
        
    }
    public function order_fail(Request $request){        
        $user = Auth::user();
        $sslc = new SSLCommerz();
        $tran_id = $_SESSION['tran_id'];
        $order = Order::find($tran_id);
        if($request->status == "FAILED"){
            $order->status = 'decline';
            $order->payment_method = 'card failed';
            $order->save();           
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
            $order->status = 'decline';
            $order->payment_method = 'Cancelled by User';       
            $order->save();
        }
        session()->flash('error', 'The payment corresponding to the order has been canceled.');
        return view('site.pages.paynotify', compact('order'));        
    }
}
