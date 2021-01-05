<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Http\Controllers\BaseController;
use App\Models\Client;

class MISReportController extends BaseController
{
    public function profitLoss(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'MIS Report', 'subTitle' => 'Profit and Loss Report' ]);        
        return view('admin.report.mis.profitloss.profitloss');
    }

    public function getprofitloss(Request $request){
        //converting date format from m-d-Y to Y-m-d as database stroes date in 'Y-m-d' format
        $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
                 
        // profit-loss calculation
        if('productwise'== $request->profitLossOption){ // productwise profit-loss report
            $time_sales = DB::table('salebackups')
                ->select('product_id', 'product_name', DB::raw('SUM(product_quantity) as total_qty, unit_price * SUM(product_quantity) as sales')) 
                ->whereRaw('order_cancel = 0')
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->groupBy('product_id', 'product_name', 'unit_price')               
                ->get();

            // Attaching pagetitle and subtitle to view.
            view()->share(['pageTitle' => 'MIS Report', 'subTitle' => 'Profit and Loss Report' ]);
            return view('admin.report.mis.profitloss.profitlossview')->with([
                'time_sales' => $time_sales,
                'start_date' => $start_date,
                'end_date'  => $end_date,
                'discount'  => $this->Discount($start_date, $end_date), 
                // 'complimentary_sales' => $complimentary_sales,
                'complimentary_sales_cost' => $this->Complimentary($start_date, $end_date),
                'productwise'=> 1, // productwise true
            ]);
        }else{ // summary profit-loss report 
            $time_sales = DB::table('salebackups')
                ->join('recipes', 'salebackups.product_id', '=', 'recipes.product_id')            
                ->select(DB::raw('unit_price * SUM(product_quantity) as sales, recipes.production_food_cost*SUM(product_quantity) as salesCost')) 
                ->whereRaw('order_cancel = 0')
                ->whereDate('salebackups.created_at', '>=', $start_date)
                ->whereDate('salebackups.created_at', '<=', $end_date)                
                ->groupBy('unit_price', 'recipes.production_food_cost')->get();

            // Attaching pagetitle and subtitle to view.
            view()->share(['pageTitle' => 'MIS Report', 'subTitle' => 'Profit and Loss Report' ]);
            return view('admin.report.mis.profitloss.profitlossviewsummary')->with([
                'time_sales' => $time_sales,
                'start_date' => $start_date,
                'end_date'  => $end_date,
                'discount'  => $this->Discount($start_date, $end_date), 
                //'complimentary_sales' => $complimentary_sales,
                'complimentary_sales_cost' => $this->Complimentary($start_date, $end_date),
                'summary'=> 1, // summary report true
            ]);
        }
        
    }

    //getting complimentary sales [Free of charge ] and  sales Cost for profit-loss report
    public function Complimentary($start_date, $end_date){

        $complimentary_all= DB::table('complimentarysales')
        ->join('recipes', 'complimentarysales.product_id', '=', 'recipes.product_id')            
        ->select(DB::raw('unit_price * SUM(product_quantity) as sales, recipes.production_food_cost*SUM(product_quantity) as salesCost')) 
        ->whereRaw('complimentary_ordersales_id is NOT NULL')
        ->whereDate('complimentarysales.created_at', '>=', $start_date)
        ->whereDate('complimentarysales.created_at', '<=', $end_date)                
        ->groupBy('unit_price', 'recipes.production_food_cost')->get();

        //$complimentary_sales = 0.0;
        $complimentary_sales_cost = 0.0;
        foreach($complimentary_all as $complimentary){
            //$complimentary_sales += $complimentary->sales;
            $complimentary_sales_cost += $complimentary->salesCost;
        }

        return $complimentary_sales_cost;

    }

    // getting reference discount for profit-loss report
    public function Discount($start_date, $end_date){

        $discount = DB::table('ordersales')
        ->select(DB::raw('SUM(discount) as ref_discount, SUM(reward_discount) as point_discount, SUM(grand_total) as total_sales'))
        ->whereDate('created_at', '>=', $start_date)
        ->whereDate('created_at', '<=', $end_date)
        ->first();

        return $discount;
    }

    //pdf profit-loss report
    public function pdfgetprofitloss($start_date, $end_date, $option){

        $discount = $this->Discount($start_date, $end_date);               
        $complimentary_sales_cost = $this->Complimentary($start_date, $end_date);
        
        if('product'== $option){ // productwise profit-loss report
            $time_sales = DB::table('salebackups')
                ->join('recipes', 'salebackups.product_id', '=', 'recipes.product_id')
                ->select('product_name', DB::raw('SUM(product_quantity) as qty, unit_price * SUM(product_quantity) as sales, recipes.production_food_cost*SUM(product_quantity) as salesCost')) 
                ->whereRaw('order_cancel = 0')
                ->whereDate('salebackups.created_at', '>=', $start_date)
                ->whereDate('salebackups.created_at', '<=', $end_date)
                ->groupBy('recipes.production_food_cost', 'product_name', 'unit_price')               
                ->get();

            $pdf = PDF::loadView('admin.report.mis.pdf.pdfproductprofitloss', compact('time_sales', 'start_date', 'end_date','discount','complimentary_sales_cost'))
            ->setPaper('a4', 'potrait');
            return $pdf->stream('pdfproductprofitloss.pdf');

        }else{ // summarywise profit-loss report
            $time_sales = DB::table('salebackups')
                ->join('recipes', 'salebackups.product_id', '=', 'recipes.product_id')            
                ->select(DB::raw('unit_price * SUM(product_quantity) as sales, recipes.production_food_cost*SUM(product_quantity) as salesCost')) 
                ->whereRaw('order_cancel = 0')
                ->whereDate('salebackups.created_at', '>=', $start_date)
                ->whereDate('salebackups.created_at', '<=', $end_date)                
                ->groupBy('unit_price', 'recipes.production_food_cost')->get();
            
            $pdf = PDF::loadView('admin.report.mis.pdf.pdfsummaryprofitloss', compact('time_sales', 'start_date', 'end_date','discount','complimentary_sales_cost'))
            ->setPaper('a4', 'potrait');
            return $pdf->stream('pdfsummaryprofitloss.pdf');
        }
        
     
    }
    
    public function cashRegister(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'MIS Report', 'subTitle' => 'Cash Register Wise Sales Report']);        
        return view('admin.report.mis.cashRegister.cashRegisterForm');
    }

    public function getCashRegister(Request $request){
        //converting date format from m-d-Y to Y-m-d as database stroes date in 'Y-m-d' format
        $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');

        $net_ref_discount = 0.0;
        $net_points_discount = 0.0;
        $net_sales = 0.0;
        $net_cash_sales = 0.0;
        $net_card_sales = 0.0;
        $net_mobile_sales = 0.0;
       
        //cash register wise report
        $cashRegister = DB::table('ordersales')
        ->select('order_number','grand_total','order_date', 'payment_method', 'discount','reward_discount','cash_pay', 'card_pay', 'mobile_banking_pay')
        ->whereRaw('order_tableNo is NULL')
        ->whereDate('created_at', '>=', $start_date)
        ->whereDate('created_at', '<=', $end_date)
        ->orderByRaw('order_number DESC')
        ->get();

        //accumulating discount, sales,
        foreach($cashRegister as $cash){
            $net_ref_discount += $cash->discount;
            $net_points_discount += $cash->reward_discount;
            $net_sales += $cash->grand_total;
            $net_cash_sales += $cash->cash_pay;
            $net_card_sales += $cash->card_pay;
            $net_mobile_sales += $cash->mobile_banking_pay;
        }
        
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'MIS Report', 'subTitle' => 'Cash Register Wise Sales Report' ]);
        return view('admin.report.mis.cashRegister.cashregisterview')->with([
            'cash_register' => $cashRegister,
            'start_date' => $start_date,
            'end_date'  => $end_date,
            'net_ref_discount' => $net_ref_discount,
            'net_points_discount' => $net_points_discount,
            'net_sales' => $net_sales,
            'net_cash_sales' => $net_cash_sales,
            'net_card_sales' => $net_card_sales,
            'net_mobile_sales' => $net_mobile_sales,
        ]);

    }

    public function pdfgetCashRegister($start_date, $end_date){
        
        $net_ref_discount = 0.0;
        $net_points_discount = 0.0;
        $net_sales = 0.0;
        $net_cash_sales = 0.0;
        $net_card_sales = 0.0;
        $net_mobile_sales = 0.0;
       
        //cash register wise report
        $cash_register = DB::table('ordersales')
        ->select('order_number','grand_total','order_date', 'payment_method', 'discount','reward_discount','cash_pay', 'card_pay', 'mobile_banking_pay')
        ->whereRaw('order_tableNo is NULL')
        ->whereDate('created_at', '>=', $start_date)
        ->whereDate('created_at', '<=', $end_date)
        ->orderByRaw('order_number DESC')
        ->get();

        //accumulating discount, sales,
        foreach($cash_register as $cash){
            $net_ref_discount += $cash->discount;
            $net_points_discount += $cash->reward_discount;
            $net_sales += $cash->grand_total;
            $net_cash_sales += $cash->cash_pay;
            $net_card_sales += $cash->card_pay;
            $net_mobile_sales += $cash->mobile_banking_pay;
        }

        $pdf = PDF::loadView('admin.report.mis.pdf.pdfCashRegister', compact('cash_register', 'start_date', 'end_date', 
        'net_ref_discount', 'net_points_discount', 'net_sales', 'net_cash_sales', 'net_card_sales', 'net_mobile_sales'))
        ->setPaper('a4', 'potrait');
        return $pdf->stream('pdfCashRegister.pdf');
    }

    public function customerSales(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'MIS Report', 'subTitle' => 'Customer Wise Sales Report' ]);
        //$clients= DB::table('clients')->select('id','name')->limit(5)->get();        
        return view('admin.report.mis.customersales.customersalesform');
    }

   /*
    customerSearchAjax: Select2 Ajax request.
   */   
    public function getClients(Request $request){
        
      $search = $request->search;

      if($search == ''){
         $clients = Client::orderby('name','asc')->select('id','name')->limit(5)->get();
      }else{
         $clients = Client::orderby('name','asc')->select('id','name')
         ->where('name', 'like', '%' .$search . '%')
         ->limit(5)->get();
      }

      $response = array();
      foreach($clients as $client){
         $response[] = array(
              "id"=>$client->id,
              "text"=>$client->name
         );
      }

      return json_encode($response);
      
    }

    public function getCustomerSales(Request $request){
       
       $client = DB::table('clients')
       ->select('id','name','mobile', 'total_points','address')
       ->where('id', $request->customer)
       ->first();

       //converting date format from m-d-Y to Y-m-d as database stroes date in 'Y-m-d' format
       $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
       $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');

       //customer wise sales report
       $customerReceipt = DB::table('ordersales')
       ->select('order_number','grand_total', 'discount','reward_discount')
       ->where('client_id', $request->customer)
       ->whereDate('created_at', '>=', $start_date)
       ->whereDate('created_at', '<=', $end_date)
       ->orderByRaw('order_number DESC')
       ->get();

       // Attaching pagetitle and subtitle to view.
       view()->share(['pageTitle' => 'MIS Report', 'subTitle' => 'Customer Wise Sales Report' ]);
       return view('admin.report.mis.customersales.customersalesview')->with([
           'customer_receipt' => $customerReceipt,
           'start_date' => $start_date,
           'end_date'  => $end_date,
           'client' => $client,
       ]);

    }

    public function pdfgetCustomerSales($start_date, $end_date, $clientId){

        $client = DB::table('clients')
       ->select('id','name','mobile', 'total_points','address')
       ->where('id', $clientId)
       ->first();

        //customer wise sales report
        $customer_receipts = DB::table('ordersales')
        ->select('order_number','grand_total', 'discount','reward_discount')
        ->where('client_id', $clientId)
        ->whereDate('created_at', '>=', $start_date)
        ->whereDate('created_at', '<=', $end_date)
        ->orderByRaw('order_number DESC')
        ->get();

        $pdf = PDF::loadView('admin.report.mis.pdf.pdfCustomerSales', compact('customer_receipts', 'start_date', 'end_date', 'client'))
        ->setPaper('a4', 'potrait');
        return $pdf->stream('pdfCustomerSales.pdf');
    }
    
    public function bonusPoint(){
      //cash register wise report
      $customer_points = DB::table('clients')
      ->select('id','name','mobile', 'total_points')
      ->orderByRaw('id asc')
      ->get();

      // Attaching pagetitle and subtitle to view.
      view()->share(['pageTitle' => 'MIS Report', 'subTitle' => 'Customer Bonus Points Report' ]);
      return view('admin.report.mis.bonuspoint.bonuspointview',compact('customer_points'));
    }

    public function pdfgetBonusPoints(){
        //Customer bonus points report
        $bonus_points = DB::table('clients')
        ->select('id','name','mobile', 'total_points')
        ->orderByRaw('id asc')
        ->get();

        $pdf = PDF::loadView('admin.report.mis.pdf.pdfbonuspoint', compact('bonus_points'))
        ->setPaper('a4', 'potrait');
        return $pdf->stream('pdfCustomerBonusPoint.pdf');
        
    }

    public function complimentarySales(){
         // Attaching pagetitle and subtitle to view.
         view()->share(['pageTitle' => 'MIS Report', 'subTitle' => 'Complimentary Sales report']);        
         return view('admin.report.mis.complimentary.complimentaryForm');
    }

    public function getcomplimentarySales(Request $request){
        //converting date format from m-d-Y to Y-m-d as database stroes date in 'Y-m-d' format
        $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');

        $complimentary_sales = DB::table('complimentarysales')
            ->join('complimentary_ordersales', 'complimentarysales.complimentary_ordersales_id', '=', 'complimentary_ordersales.id')            
            ->join('recipes', 'complimentarysales.product_id', '=', 'recipes.product_id')  
            ->select('order_number', 'notes', 'order_date','product_name', DB::raw('SUM(product_quantity) as total_qty, recipes.production_food_cost*SUM(product_quantity) as salesCost'))            
            ->whereDate('complimentarysales.created_at', '>=', $start_date)
            ->whereDate('complimentarysales.created_at', '<=', $end_date)
            ->groupBy('recipes.production_food_cost', 'order_number', 'product_name', 'order_date', 'notes')
            ->orderByRaw('order_number DESC')->get();
        
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'MIS Report', 'subTitle' => 'Complimentary Sales report' ]);
        return view('admin.report.mis.complimentary.complimentaryview')->with([
            'complimentary_sales' => $complimentary_sales,
            'start_date' => $start_date,
            'end_date'  => $end_date,           
        ]);
        
    }

    public function pdfcomplimentarySales($start_date, $end_date){
      
       $complimentary_sales = DB::table('complimentarysales')
            ->join('complimentary_ordersales', 'complimentarysales.complimentary_ordersales_id', '=', 'complimentary_ordersales.id')            
            ->join('recipes', 'complimentarysales.product_id', '=', 'recipes.product_id')  
            ->select('order_number','notes','order_date','product_name', DB::raw('SUM(product_quantity) as total_qty, recipes.production_food_cost*SUM(product_quantity) as salesCost'))            
            ->whereDate('complimentarysales.created_at', '>=', $start_date)
            ->whereDate('complimentarysales.created_at', '<=', $end_date)
            ->groupBy('recipes.production_food_cost', 'order_number', 'product_name', 'order_date', 'notes')
            ->orderByRaw('order_number asc')->get();

        $pdf = PDF::loadView('admin.report.mis.pdf.pdfcomplimentarysales', compact('complimentary_sales','start_date', 'end_date'))
        ->setPaper('a4', 'potrait');
        return $pdf->stream('pdfcomplimentarysales.pdf');
    }

    public function stock(){
         // Attaching pagetitle and subtitle to view.
         view()->share(['pageTitle' => 'MIS Report', 'subTitle' => 'Stock Report' ]);        
         return view('admin.report.mis.stock.stockform');
    }

    public function getstock(Request $request){ 
         if("product" == $request->stockOption){
            $ingredients = DB::table('ingredients')
            ->select('name','total_quantity','alert_quantity', 'measurement_unit', 'total_price' ) 
            ->orderByRaw('alert_quantity asc')->get();
        
            // Attaching pagetitle and subtitle to view.
            view()->share(['pageTitle' => 'MIS Report', 'subTitle' => 'Stock Analysis Report' ]);
            return view('admin.report.mis.stock.stockview')->with([
                'ingredients' => $ingredients,                     
            ]);
         }
         else{
             //selecting stock ingredient category option and $request->stockOption holds ingredient category id value.
             $ingredients = DB::table('ingredients')
             ->select('name','total_quantity','alert_quantity', 'measurement_unit', 'total_price' ) 
             ->where('typeingredient_id', $request->stockOption)
             ->orderByRaw('alert_quantity asc')->get();
         
             // Attaching pagetitle and subtitle to view.
             view()->share(['pageTitle' => 'MIS Report', 'subTitle' => 'Stock Analysis Report' ]);
             return view('admin.report.mis.stock.stocktypeview')->with([
                 'ingredients' => $ingredients, 
                 'cat_id'  => $request->stockOption,                 
             ]);
         }
    }

    public function pdfstock($stockoption){

        if("product" == $stockoption){
            $ingredients = DB::table('ingredients')
            ->select('name','total_quantity','alert_quantity', 'measurement_unit', 'total_price' ) 
            ->orderByRaw('alert_quantity asc')->get();
            $stockoption = 0; // changing value from 'product' to 0
            $pdf = PDF::loadView('admin.report.mis.pdf.pdfstockproduct', compact('ingredients', 'stockoption'))
            ->setPaper('a4', 'potrait');
            return $pdf->stream('pdfstockproduct.pdf');
         }
         else{
             //selecting stock ingredient category option and $request->stockOption holds ingredient category id value.
             $ingredients = DB::table('ingredients')
             ->select('name','total_quantity','alert_quantity', 'measurement_unit', 'total_price' ) 
             ->where('typeingredient_id', $stockoption)
             ->orderByRaw('alert_quantity asc')->get();
         
             $pdf = PDF::loadView('admin.report.mis.pdf.pdfstockproduct', compact('ingredients', 'stockoption'))
             ->setPaper('a4', 'potrait');
             return $pdf->stream('pdfstockproduct.pdf');
         }
       
    }


    public function combinedprofitLoss(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'MIS Reports', 'subTitle' => 'Combined Profit and Loss Report' ]);        
        return view('admin.report.mis.profitloss.combinedprofitlossform');
    }

    public function getcombinedprofitLoss(Request $request){

        //converting date format from m-d-Y to Y-m-d as database stroes date in 'Y-m-d' format
        $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
             
        //e-commerce profit-loss
        $ecom_sales = DB::table('cartbackups')
            ->join('recipes', 'cartbackups.product_id', '=', 'recipes.product_id') 
            ->join('orders', 'orders.id', '=', 'cartbackups.order_id')            
            ->select(DB::raw('unit_price * SUM(product_quantity) as sales, recipes.production_food_cost*SUM(product_quantity) as salesCost')) 
            ->where('orders.status', 'delivered')
            ->whereDate('cartbackups.created_at', '>=', $start_date)
            ->whereDate('cartbackups.created_at', '<=', $end_date)                
            ->groupBy('unit_price', 'recipes.production_food_cost')->get();        

        //KOT/MIS profit-loss
        $kot_sales = DB::table('salebackups')
            ->join('recipes', 'salebackups.product_id', '=', 'recipes.product_id')            
            ->select(DB::raw('unit_price * SUM(product_quantity) as sales, recipes.production_food_cost*SUM(product_quantity) as salesCost')) 
            ->whereRaw('order_cancel = 0')
            ->whereDate('salebackups.created_at', '>=', $start_date)
            ->whereDate('salebackups.created_at', '<=', $end_date)                
            ->groupBy('unit_price', 'recipes.production_food_cost')->get();

        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'MIS Reports', 'subTitle' => 'Combined Profit and Loss Report' ]);
        return view('admin.report.mis.profitloss.combinedprofitlossview')->with([
            'ecom_sales' => $ecom_sales,
            'kot_sales' => $kot_sales,
            'start_date' => $start_date,
            'end_date'  => $end_date,           
            // Getting e-commerce grand totals of total orders of the specified date.
            'ecom_total_sales' => $this->getGrandTotal($start_date, $end_date)->total_sales,
            // pos/kot discount sales.
            'discount'  => $this->Discount($start_date, $end_date), 
            // POS/kot complimentary_sales
            'complimentary_sales_cost' => $this->Complimentary($start_date, $end_date),
        ]);
    }

    //Getting grand total of e-commerce orders
    public function getGrandTotal($start_date, $end_date){

        $grandTotal = DB::table('orders')
        ->select(DB::raw('SUM(grand_total) as total_sales'))
        ->where('orders.status', 'delivered')
        ->whereDate('created_at', '>=', $start_date)
        ->whereDate('created_at', '<=', $end_date)
        ->first();

        return $grandTotal;        
    }

    public function pdfcombinedgetprofitloss($start_date, $end_date){
       
        //e-commerce profit-loss
        $ecom_sales = DB::table('cartbackups')
            ->join('recipes', 'cartbackups.product_id', '=', 'recipes.product_id') 
            ->join('orders', 'orders.id', '=', 'cartbackups.order_id')            
            ->select(DB::raw('unit_price * SUM(product_quantity) as sales, recipes.production_food_cost*SUM(product_quantity) as salesCost')) 
            ->where('orders.status', 'delivered')
            ->whereDate('cartbackups.created_at', '>=', $start_date)
            ->whereDate('cartbackups.created_at', '<=', $end_date)                
            ->groupBy('unit_price', 'recipes.production_food_cost')->get();        

        //KOT/MIS profit-loss
        $kot_sales = DB::table('salebackups')
            ->join('recipes', 'salebackups.product_id', '=', 'recipes.product_id')            
            ->select(DB::raw('unit_price * SUM(product_quantity) as sales, recipes.production_food_cost*SUM(product_quantity) as salesCost')) 
            ->whereRaw('order_cancel = 0')
            ->whereDate('salebackups.created_at', '>=', $start_date)
            ->whereDate('salebackups.created_at', '<=', $end_date)                
            ->groupBy('unit_price', 'recipes.production_food_cost')->get();
        
        // Getting e-commerce grand totals of total orders of the specified date.
        $ecom_total_sales = $this->getGrandTotal($start_date, $end_date)->total_sales;
        // pos/kot discount sales.
        $discount  = $this->Discount($start_date, $end_date);
        // POS/kot complimentary_sales
        $complimentary_sales_cost = $this->Complimentary($start_date, $end_date);

        $pdf = PDF::loadView('admin.report.mis.pdf.pdfcombinedprofitloss', 
        compact('ecom_sales', 'kot_sales', 'start_date', 'end_date', 'discount', 'complimentary_sales_cost', 'ecom_total_sales'))->setPaper('a4', 'potrait');        
        return $pdf->stream('pdfcombinedprofitloss.pdf');
    }
}
