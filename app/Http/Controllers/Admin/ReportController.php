<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Product;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DailyExport;
use App\Exports\DailyTotalExport;
use App\Exports\MonthlyTotalExport;
use App\Exports\YearlyTotalExport;
use App\Exports\ItemBasedExport;
use App\Exports\SingleItemExport;



class ReportController extends Controller
{
    public function dailyCarts(){

        //Product wise daily sale reports 
        $daily_carts  = DB::table('carts')
                ->select('product_id', 'unit_price', DB::raw('SUM(product_quantity) as total_qty, unit_price * SUM(product_quantity) as subtotal')) 
                ->whereRaw('has_attribute = 0 and order_id is not NULL and order_cancel = 0 and date(created_at) = CURDATE() - INTERVAL 1 DAY')
                ->groupBy('product_id', 'unit_price')
                ->orderByRaw('SUM(product_quantity) DESC')
                ->get();

        return $daily_carts;
    }    
    
    public function daily(){
        $daily_carts = $this->dailyCarts();
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Daliy Sale', 'subTitle' => 'Product wise Daily Sale' ]);
        return view('admin.report.daily', compact('daily_carts'));     
    }

    public function pdfdaily(){        
        $daily_carts = $this->dailyCarts();
        $pdf = PDF::loadView('admin.report.pdf.pdfdaily', compact('daily_carts'));
        return $pdf->stream('dailyitemsale.pdf');
    }

    public function exceldaily(){ 
        return Excel::download(new DailyExport(), 'daily_report.xlsx');
    }

    public function dailyTotal(){  
        //Day wise sale reports 
        $daily_totals = DB::table('carts')
            ->select( DB::raw('Date(created_at) as date, SUM(product_quantity * unit_price ) as subtotal')) 
            ->whereRaw('has_attribute = 0 and order_id is not NULL and order_cancel = 0')
            ->groupByRaw('Date(created_at)')
            ->orderByRaw('Date(created_at) DESC')
            ->paginate(10);       
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Daily Sale', 'subTitle' => 'Per Day Sale Amount' ]);
        return view('admin.report.daytotal', compact('daily_totals'));
    }

    public function pdfDailyTotal(){
        //Day wise sale reports 
        $daily_totals = DB::table('carts')
        ->select( DB::raw('Date(created_at) as date, SUM(product_quantity * unit_price ) as subtotal')) 
        ->whereRaw('has_attribute = 0 and order_id is not NULL and order_cancel = 0')
        ->groupByRaw('Date(created_at)')
        ->orderByRaw('Date(created_at) DESC')
        ->get();  

        $pdf = PDF::loadView('admin.report.pdf.pdfdaytotal', compact('daily_totals'));
        return $pdf->stream('dailysale.pdf');
    }

    public function excelDailyTotal(){
        return Excel::download(new DailyTotalExport(), 'daily_total.xlsx');
    }

    
    public function monthlytotal(){
        //Month wise sale reports 
        $monthly_totals = DB::table('carts')
        ->select( DB::raw('DATE_FORMAT(created_at, "%Y-%m") as yearMonth, SUM(product_quantity * unit_price ) as subTotal')) 
        ->whereRaw('has_attribute = 0 and order_id is not NULL and order_cancel = 0')
        ->groupByRaw('DATE_FORMAT(created_at, "%Y-%m")')         
        ->orderByRaw('DATE_FORMAT(created_at, "%Y-%m") DESC')
        ->paginate(12);
   
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Monthly Sale', 'subTitle' => 'Per Month Sale Amount' ]);
        return view('admin.report.monthtotal', compact('monthly_totals'));        
    }

    public function pdfMonthlyTotal(){

         //Month wise sale reports 
         $monthly_totals = DB::table('carts')
         ->select( DB::raw('DATE_FORMAT(created_at, "%Y-%m") as yearMonth, SUM(product_quantity * unit_price ) as subtotal')) 
         ->whereRaw('has_attribute = 0 and order_id is not NULL and order_cancel = 0')
         ->groupByRaw('DATE_FORMAT(created_at, "%Y-%m")')         
         ->orderByRaw('DATE_FORMAT(created_at, "%Y-%m") DESC')
         ->get();

         $pdf = PDF::loadView('admin.report.pdf.pdfmonthtotal', compact('monthly_totals'));
         return $pdf->stream('monthlysale.pdf');
    }

    public function excelMonthlyTotal(){        
        return Excel::download(new MonthlyTotalExport(), 'monthly_total.xlsx');
    }

    public function yearlytotal(){
        //Year based sale reports 
        $yearly_totals = DB::table('carts')
            ->select( DB::raw('Year(created_at) as year, SUM(product_quantity * unit_price ) as subTotal')) 
            ->whereRaw('has_attribute = 0 and order_id is not NULL and order_cancel = 0')
            ->groupByRaw('Year(created_at)')         
            ->orderByRaw('Year(created_at) DESC')
            ->paginate(10);
   
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Yearly Sale', 'subTitle' => 'Year Based Sale ' ]);
        return view('admin.report.yeartotal', compact('yearly_totals'));   
    }

    public function pdfYearlyTotal(){
             //Year based sale reports 
        $yearly_totals = DB::table('carts')
            ->select( DB::raw('Year(created_at) as year, SUM(product_quantity * unit_price ) as subtotal')) 
            ->whereRaw('has_attribute = 0 and order_id is not NULL and order_cancel = 0')
            ->groupByRaw('Year(created_at)')         
            ->orderByRaw('Year(created_at) DESC')
            ->get();
        
        $pdf = PDF::loadView('admin.report.pdf.pdfyeartotal', compact('yearly_totals'));
        return $pdf->stream('yearlysale.pdf');
    }

    public function excelYearlyTotal(){
        return Excel::download(new YearlyTotalExport(), 'yearly_total.xlsx');
    }


    public function top20(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Top 20', 'subTitle' => 'List of Top 20 Sale Items' ]);        
        return view('admin.report.itemform');
    }

    public function getTop20(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        //Top20 sale reports 
        $time_carts = DB::table('carts')
                ->select('product_id', 'unit_price', DB::raw('SUM(product_quantity) as total_qty, unit_price * SUM(product_quantity) as subtotal')) 
                ->whereRaw('has_attribute = 0 and order_id is not NULL and order_cancel = 0')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->groupBy('product_id', 'unit_price')
                ->orderByRaw('SUM(product_quantity) DESC')
                ->get();
        
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Top20 Sale', 'subTitle' => 'Anytime Top20 Food Sale' ]);
        return view('admin.report.top20')->with([
            'time_carts' => $time_carts,
            'start_date' => $start_date,
            'end_date'  => $end_date,
        ]);
        
    }

    public function pdfGetTop20($start_date, $end_date){

        $time_carts = DB::table('carts')
                ->select('product_id', 'unit_price', DB::raw('SUM(product_quantity) as total_qty, unit_price * SUM(product_quantity) as subtotal')) 
                ->whereRaw('has_attribute = 0 and order_id is not NULL and order_cancel = 0')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->groupBy('product_id', 'unit_price')
                ->orderByRaw('SUM(product_quantity) DESC')
                ->get();

        $pdf = PDF::loadView('admin.report.pdf.pdftop20', compact('time_carts', 'start_date', 'end_date'));
        return $pdf->stream('AnytimeTop20sale.pdf');
    }

    public function excelGetTop20($start_date, $end_date){
        return Excel::download(new ItemBasedExport($start_date, $end_date), 'Item_based_sale.xlsx');
    }
    
    public function single(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Individual Item Sale', 'subTitle' => 'Individual Item Sale Details' ]);        
        return view('admin.report.singleitemform');
    }

    public function singleSale(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $search = $request->search_food;      
        $product = Product::where('name', 'like', '%'.$search.'%')->first();
        //single item sale reports 
        $single_carts = DB::table('carts')
                ->select('product_id', 'unit_price', DB::raw('Date(created_at) as date, SUM(product_quantity) as total_qty, unit_price * SUM(product_quantity) as subtotal')) 
                ->whereRaw('has_attribute = 0 and order_id is not NULL and order_cancel = 0')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->where('product_id', $product->id)
                ->groupByRaw('Date(created_at), product_id, unit_price')
                ->orderByRaw('Date(created_at) DESC')
                ->get();           
        
        //Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Individual Item Sale', 'subTitle' => 'Individual Item Sale Details' ]);
        return view('admin.report.singleitem')->with([
            'single_carts' => $single_carts,
            'start_date' => $start_date,
            'end_date'  => $end_date,
            'search_food' => $search,
        ]);        
        
    }

    public function pdfSingleSale($start_date, $end_date, $search){

        $product = Product::where('name', 'like', '%'.$search.'%')->first();
        //single item sale reports 
        $single_carts = DB::table('carts')
                ->select('product_id', 'unit_price', DB::raw('Date(created_at) as date, SUM(product_quantity) as total_qty, unit_price * SUM(product_quantity) as subtotal')) 
                ->whereRaw('has_attribute = 0 and order_id is not NULL and order_cancel = 0')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->where('product_id', $product->id)
                ->groupByRaw('Date(created_at), product_id, unit_price')
                ->orderByRaw('Date(created_at) DESC')
                ->get(); 
        
        $pdf = PDF::loadView('admin.report.pdf.pdfsingleitem', compact('single_carts', 'start_date', 'end_date'));
        return $pdf->stream('AnytimeSingleSale.pdf');

    }

    public function excelSingleSale($start_date, $end_date, $search){        
        return Excel::download(new SingleItemExport($start_date, $end_date, $search), 'Single_item_sale.xlsx');
    }

  
   
}
