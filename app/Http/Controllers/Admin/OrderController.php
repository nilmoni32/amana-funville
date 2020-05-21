<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\BaseController;

class OrderController extends BaseController
{
    public function index(){
         // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Orders', 'subTitle' => 'List of all orders' ]);
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
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
        $order->status = $request->status;
        $order->save();        
        return $this->responseRedirectBack(' Order status is updated successfully' ,'success', false, false);         
    }
}
