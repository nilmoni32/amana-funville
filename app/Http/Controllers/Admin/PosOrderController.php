<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Ordersale;
use App\Traits\FlashMessages; 
use Carbon\Carbon;
use DateTime;

class PosOrderController extends Controller
{
    use FlashMessages;

    public function index(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'POS Orders', 'subTitle' => 'List of all POS Orders' ]);
        $orders = Ordersale::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.sales.orders.index', compact('orders'));
    }

    public function edit($id){
        // Attaching pagetitle and subtitle to view.          
        $order = Ordersale::where('id', $id)->first();
        view()->share(['pageTitle' => 'POS Orders', 'subTitle' => 'POS Order No: '.$order->order_number ]);
        return view('admin.sales.orders.edit', compact('order'));
    }

    public function update(Request $request){

        $this->validate($request,[  
            'order_tableNo'    => 'required|string|max:10',
            'status'           => 'nullable|string|max:40',             
                        
        ]);
        
        $order = Ordersale::where('id', $request->id)->first();       
        $order->order_tableNo = $request->order_tableNo;      
        $order->status = $request->status;
        $order->save(); 

        // setting flash message using trait
        $this->setFlashMessage(' Order is updated successfully', 'success');    
        $this->showFlashMessages();
        return redirect()->route('admin.pos.orders.index');
    }


    public function search(Request $request){
       $search = trim($request->search); // getting the search key
       
      // search criteria.      
       $orders = Ordersale::orWhere('order_number', 'like', '%'.$search.'%')       
       ->orWhere('order_date', 'like', '%'. ($this->validateDateTime($search) ? Carbon::createFromFormat('d-m-Y H:i:s', $search)->format('Y-m-d H:i:s') : $search).'%')   
       ->orWhere('order_date', 'like', '%'. ($this->validateDate($search) ? Carbon::createFromFormat('d-m-Y', $search)->format('Y-m-d') : $search).'%')     
       ->orWhere('order_tableNo', 'like', '%'.$search.'%')                 
       ->orWhere('grand_total', 'like', '%'.$search.'%') 
       ->orWhere('status', 'like', '%'.$search.'%')     
       ->orWhere('payment_method', 'like', '%'.$search.'%')->paginate(15); 
        
        // Attaching pagetitle and subtitle to view.
       view()->share(['pageTitle' => 'POS Orders', 'subTitle' => 'List of Search Orders' ]);
       return view('admin.sales.orders.index', compact('orders'));
   }

   
   public function validateDateTime($date, $format = 'd-m-Y H:i:s')
   {
       $d = DateTime::createFromFormat($format, $date);
       return $d && $d->format($format) == $date;
   }

   public function validateDate($date, $format = 'd-m-Y')
   {
       $d = DateTime::createFromFormat($format, $date);
       return $d && $d->format($format) == $date;
   }


}
