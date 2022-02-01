<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Duesale;
use App\Models\Unit;
use App\Models\Recipe;
use App\Models\Product;
use App\Models\Category;
use App\Models\Dueordersale;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Traits\FlashMessages; 
use App\Http\Controllers\Controller;
use App\Models\Client;
use DateTime;
use Carbon\Carbon;
use App\Http\Controllers\BaseController;

class DuePosSalesController extends BaseController
{
    use FlashMessages;

    public function index(){
        //Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Kitchen Order Ticketing System', 'subTitle' => 'Place an order with customer details with advance payment' ]);
        return view('admin.sales.due.index');        
    }
   
    public function orderplace(Request $request){
      
        $this->validate($request,[  
            'order_tableNo'    => 'required|string|max:10',
            'booked_money'     => 'required|regex:/^\d+(\.\d{1,2})?$/',
            // 'payment_date'     => 'required|string',
            'customer_name'     => 'required|string|max:50',             
            'customer_mobile'   => 'required|regex:/(01)[3-9]{1}(\d){8}/|max:11',
            'customer_address'  => 'nullable|string|max:191',       
            'customer_notes'    => 'nullable|string|max:191', 
        ]);
        
        //checking the table no for usability   
        if(Dueordersale::where('order_tableNo', $request->order_tableNo)->first()){
            // setting flash message using trait
            $this->setFlashMessage(" Your selected table '".$request->order_tableNo."' is currently in use, please select another table", 'error');    
            $this->showFlashMessages(); 
            return redirect()->back();
        }

        //checking if client not exists, we create client here to store client information. 
        $client = Client::where('mobile', $request->customer_mobile)->first() ?? new Client();        
        $client->name = $request->customer_name;        
        $client->mobile = $request->customer_mobile;
        if($request->customer_address){
            $client->address = $request->customer_address;
        }
        if($request->customer_notes){
            $client->notes = $request->customer_notes;
        }        
        $client->save();

        // finding last order id: we use it for customer order id (customized) for billing purpose
        // it will be false only for the first record.
        if(!Dueordersale::orderBy('id', 'desc')->first()){
            $ord_id = 0;
        }
        else{
            $ord_id = Dueordersale::orderBy('id', 'desc')->first()->id; 
        }   
        $ord_id = '#'.(10000 + ($ord_id + 1));

        $order = new Dueordersale(); // we use order_id as online transaction id.
        $order->admin_id = auth()->user()->id;     
        $order->order_number = $ord_id;         
        $order->order_date = \Carbon\Carbon::now()->toDateTimeString();         
        $order->order_tableNo = $request->order_tableNo;
        $order->booked_money = $request->booked_money;
        $order->receive_total = $request->booked_money; // initial receive total amount
        $order->payment_date = \Carbon\Carbon::now()->toDateTimeString();  
        // saving client id to order table
        $order->client_id = $client->id;
        $order->save();              
        
        // setting flash message using trait
        $this->setFlashMessage('Order with advance payment is created successfully', 'success');    
        $this->showFlashMessages(); 
        
        return redirect()->route('admin.due.sales.index');   
       
    } 

    public function orderLists(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'KOT Due Lists', 'subTitle' => 'List of all Due KOT Orders' ]);
        $orders = Dueordersale::orderBy('created_at', 'desc')->paginate(30);
        return view('admin.sales.due.orderlists', compact('orders')); 
    }

    public function editDueOrder($id){
        // Attaching pagetitle and subtitle to view.          
        $order = Dueordersale::where('id', $id)->first();
        view()->share(['pageTitle' => 'KOT Due Orders', 'subTitle' => 'KOT Order No: '.$order->order_number ]);
        return view('admin.sales.due.editDueOrder', compact('order'));
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

    public function calculateSubtotal($id){
        // calculating subtotal
        $total_taka=0.0;
        foreach(Duesale::where('admin_id', Auth::id())->where('dueordersale_id',$id)->get() as $sale){      
          
            if($sale->product->discount_price){
                    $total_taka += $sale->product->discount_price * $sale->product_quantity;
            }else{
                    $total_taka += $sale->product->price * $sale->product_quantity;
            }         
        }
        return $total_taka;
    }


    public function addToSales(Request $request){

        $product = Product::find($request->foodId);
        //checking discount price is enabled for this product
        if($product->discount_price){
            $sale_price = $product->discount_price;
        }else{
            $sale_price = $product->price;
        }
        // checking the food is added to the recipe
        if(!Recipe::where('product_id', $request->foodId)->first()){
            return json_encode([ 'status' => 'info', 'message' => "Please add '". $request->foodName ."' food recipe before you sale." ]);           
         }// recipe is added but recipe ingredients is not added for the food
         elseif(!Recipe::where('product_id', $request->foodId)->first()->recipeingredients->count()){          
             return json_encode([ 'status' => 'info', 'message' => "Please add '". $request->foodName ."' food recipe ingredients before you  sale." ]);
         }
         else{
            //when stock ingredient total quantity is zero or negative after sales.
            foreach(Recipe::where('product_id', $request->foodId)->first()->recipeingredients as $ingredient){
               if(Ingredient::where('id', $ingredient->ingredient_id)->first()->total_quantity <= 0){
                    return json_encode([ 'status' => 'info', 'message' => "Please add purchase record for ingredient '". 
                    Ingredient::where('id', $ingredient->ingredient_id)->first()->name ."' of food '". $request->foodName ."' before sale." ]);
                }
            }
            
         }

        //checking the product whether it is already added to the sale cart, if so we sent the message this product is already added to the cart.
        $sale = Duesale::where('admin_id', Auth::id())
                    ->where('product_id', $request->foodId)
                    ->where('dueordersale_id', $request->orderId) 
                    ->first();
        if(!is_null($sale)){
            return json_encode([ 'status' => 'info', 'message' => "This food is already added to the cart."  ]);
        }
        else{
            // adding new item to the due sales cart
            // Create a cart for due sells and store dueordersale_id & order_tbl_no
            $sale = new Duesale();
            $sale->admin_id = Auth::id(); 
            $sale->product_id = $request->foodId;
            $sale->product_name = $request->foodName;
            $sale->dueordersale_id = $request->orderId;
            $sale->order_tbl_no = $request->orderTableNo;
            $sale->unit_price = $sale_price;
            $sale->product_quantity = 1;
            $sale->save();

            return json_encode([ 'status' => 'success', 'foodname' => $sale->product_name , 'price' => $sale->unit_price, 'qty' => $sale->product_quantity, 'id' => $sale->id , 'sub_total' => $this->calculateSubtotal($sale->dueordersale_id) ]);
            
        }          
        
    }

    public function update(Request $request)
    {  
        $id = $request->sale_id;                
        $sale = Duesale::find($id);//primary key id
        $sale->product_quantity = $request->product_quantity;           
        $sale->save();        
        if($sale->product->discount_price){
                $total_unit_price = $sale->product->discount_price * $sale->product_quantity;
        }else{
                $total_unit_price = $sale->product->price * $sale->product_quantity;
        }
         
        return json_encode([ 'status' => 'success', 'total_unit_price' => $total_unit_price, 'sub_total' => $this->calculateSubtotal($sale->dueordersale_id) ]);      
    }

    public function destroy(Request $request)
    {
        $sale = Duesale::find($request->sale_id);
        if(!is_null($sale)){            
            $sale->delete();
            return json_encode([ 'status' => 'success', 'message' => 'Item is deleted', 'sub_total' => $this->calculateSubtotal($sale->dueordersale_id) ]); 
        }
        return json_encode(['status' => 'error', 'message' => 'An error is occurred while deleting the cart' ]);
    }

    /*
    * Ajax request
    */
    public function orderStatusUpdate(Request $request){
        $order = Dueordersale::find($request->id);
        $order->status = $request->status;
        if($request->status == 'cancel'){
            $order->order_tableNo = NULL;
        }
        $order->save();
        //BACKUP of POS sales: Making pos sale backup to Salebackup table 
        $saleCartBackup = [];
        foreach(Duesale::where('dueordersale_id',
        $order->id)->get() as $saleCart){
            $cart_backup = [
                'product_id' => $saleCart->product_id,
                'admin_id' => $saleCart->admin_id,
                'dueordersale_id' => $saleCart->dueordersale_id,
                'product_name' => $saleCart->product_name,
                'product_quantity' => $saleCart->product_quantity,
                'unit_price' => $saleCart->unit_price,
                'production_food_cost' => $saleCart->production_food_cost,
                'order_cancel' => 1,
                'order_tbl_no' => $saleCart->order_tbl_no,
            ];            
            $saleCartBackup[] = $cart_backup;
        } 
        \DB::table('salebackups')->insert($saleCartBackup);
        //Now Deleting record from pos sale table in order to free up space to pos sale table
        foreach(Duesale::where('dueordersale_id',
        $order->id)->get() as $saleCart){
            $saleCart->delete();
        }

        return response()->json(['success' => 'Data is updated successfully']);  
         
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

    public function search(Request $request){
        $search = trim($request->search); // getting the search key 
        // relationship with client
       // search criteria.      
        $orders = Dueordersale::orWhere('order_number', 'like', '%'.$search.'%') 
                ->orWhere('order_tableNo', 'like', '%'.$search.'%')  
                ->orWhere('order_date', 'like', '%'. ($this->validateDateTime($search) ? Carbon::createFromFormat('d-m-Y H:i:s', $search)->format('Y-m-d H:i:s') : $search).'%')   
                ->orWhere('order_date', 'like', '%'. ($this->validateDate($search) ? Carbon::createFromFormat('d-m-Y', $search)->format('Y-m-d') : $search).'%')   
                ->orWhere('receive_total', 'like', '%'.$search.'%') 
                ->orWhere('due_payable', 'like', '%'.$search.'%')
                ->orWhereHas('client', function ($query) use($search) {
                    $query->where('mobile', '=', $search);})
                ->orWhere('status', 'like', '%'.$search.'%')    
                ->paginate(10);  
         // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'KOT Due Orders', 'subTitle' => 'List of Search Orders' ]);
        return view('admin.sales.due.orderlists', compact('orders'));
    }

    public function paymentindex($id){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Due Sell KOT System', 'subTitle' => 'Selected products for sales and make order placement' ]);
        return view('admin.sales.due.payment.index')->with('order_id', $id);
    }

    public function searchDueCart(Request $request){
        $search = trim($request->search); // getting the search key        
       // search criteria.      
        $order = Dueordersale::orWhere('order_number', 'like', '%'.$search.'%')
                ->orWhere('order_tableNo', 'like', '%'.$search.'%')->first();
        if($order){
            return redirect()->route('admin.due.sales.paymentindex', $order->id); 
        }
        else{
            return $this->responseRedirectBack(' Sorry, the order table no is not found!' ,'error', false, false); 
        }
    }

    public function getMobileNo(Request $request){

        $search = $request->search;
       
        $customers = Client::orderby('name','asc')
                    ->select('name','mobile')
                    ->where('mobile', 'like', '%' .$search . '%')                    
                    ->limit(5)
                    ->get();        

        $response = array();
        foreach($customers as $customer){            
            $response[] = array( "value" => $customer->name, "label" => $customer->mobile
            );            
        }

        return response()->json($response); 
    }

    public function addCustomerInfo(Request $request){
        
        $mobile = $request->mobile;

        $customer = Client::select('name','mobile','address','notes','total_points')                    
                    ->where('mobile', 'like', '%' .$mobile . '%')
                    ->get();

        return response()->json($customer); 

    }

    public function discountSlab(Request $request){ 
        $directorId = $request->directorId;
        $orderTotal = $request->orderTotal;
        $discount = $request->discount;
        // getting the reference director using director id. 
        $director = Director::where('id', $request->directorId)->first();
        $discount_upper_limit = $director->discount_upper_limit;
        $discount_slab_percentage = $director->discount_slab_percentage;
        $discount_limit = $orderTotal * ($discount_slab_percentage/100); //percentage limit
        return json_encode(['status' => 'success', 'discountLimit' => $discount_limit, 'discount' => $discount, 'discountUpperLimit' => $discount_upper_limit ] );
    }

    public function gpStarDiscount(Request $request){
        $gpstarId = $request->gpstarId;
        $gpstar_discount = Gpstardiscount::where('id', $request->gpstarId)->first();
        $discount_percent = $gpstar_discount->discount_percent;
        $discount_upper_limit = $gpstar_discount->discount_upper_limit;
        return json_encode(['status' => 'success', 'discountPercent' => $discount_percent, 'discountUpperLimit' => $discount_upper_limit ] );
    }

    public function cardDiscount(Request $request){
        $card_bank = $request->cardBank;
        $card = Paymentgw::where('bank_type', 'card')->where('bank_name', $card_bank)->first();
        $card_discount = $card->discount_percent;
        $discount_upper_limit = $card->discount_upper_limit;
        return response()->json(['cardDiscount' => $card_discount, 'upperLimit' => $discount_upper_limit]);
    }


}
