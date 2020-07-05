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
