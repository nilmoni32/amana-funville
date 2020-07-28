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
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

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

        $order = new Ordersale(); // we use order_id as online transaction id.
        $order->admin_id = auth()->user()->id;     
        $order->order_number = $ord_id; 
        $order->grand_total = $this->calculateSubtotal();  
        $order->order_date = \Carbon\Carbon::now()->toDateTimeString(); 
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
        // setting flash message using trait
        $this->setFlashMessage(' Order is placed successfully', 'success');    
        $this->showFlashMessages(); 
        //$this->saleInvoice($order->id);
        view()->share(['pageTitle' => 'POS Sales', 'subTitle' => 'Select products for sales and make order placement' ]);       
        return view('admin.sales.index')->with('order_id', $order->id);
        
    }

    public function saleInvoice($saleOrder_id){
        
        $saleOrder = Ordersale::find($saleOrder_id);
        // dd($saleOrder->order_number);
        //Set params
        $mid = '123123456';
        $store_name = config('settings.site_name');
        $store_address = config('settings.contact_address');
        $store_phone = config('settings.phone_no');
        $store_email = config('settings.default_email_address');
        $store_website = 'funville.com';
        $store_tableNo =  $saleOrder->order_tableNo;
        $tax_percentage = config('settings.tax_percentage');
        $transaction_id = $saleOrder->order_number; 
       
        
        // Set items
        $items = [];       
        //storing values into an associative array.
        foreach(Sale::where('ordersale_id', $saleOrder->id)->get() as $saleCart){    
            $items[] = ['name' => $saleCart->product_name, 'qty' => $saleCart->product_quantity, 'price' => $saleCart->unit_price ];
        }

        //dd($items);
        
        // Init printer
        $printer = new ReceiptPrinter;
        
        $printer->init(
            //Connection protocol to communicate with the receipt printer.
            //config('receiptprinter.connector_type'),  
            config('settings.protocol'),
            //Typically printer name or IP address.
            //config('receiptprinter.connector_descriptor')
            config('settings.printer_name')
        );

         // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, $store_email, $store_website,$store_tableNo);

        // Add items
        foreach ($items as $item) {
            $printer->addItem(
                $item['name'],
                $item['qty'],
                $item['price']
            );
        }
        // Set tax
        $printer->setTax($tax_percentage);

        // Calculate total
        $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        // Set transaction ID
        $printer->setTransactionID($transaction_id);

        // Set qr code
        $printer->setQRcode([
            'tid' => $transaction_id,
        ]);

        // Print receipt
        $printer->printReceipt();

        return redirect()->back();
        
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
