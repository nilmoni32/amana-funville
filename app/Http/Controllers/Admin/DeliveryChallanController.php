<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Ingredient;
use App\Models\Supplier;
use App\Models\Unit; 
use App\Models\SupplierStock;
use App\Models\RequisitionToSupplier;
use App\Models\RequisitionIngredientList;
use Illuminate\Http\Request;
use App\Traits\FlashMessages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use PDF;

class DeliveryChallanController extends Controller
{
    use FlashMessages;
    public function index(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Supplier Delivery Challan', 'subTitle' => 'List of all received Supplier challans.' ]);        
        return view('admin.supplierChallan.index');
    }

    public function create(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Create a Supplier Delivery Challan', 'subTitle' => '' ]);   
        $suppliers = Supplier::all();     
        return view('admin.supplierChallan.create',compact('suppliers'));
    }

    public function getRequisitions($id){
        $requisitions = RequisitionToSupplier::find($id);       
        return response()->json(['success'=>true, 'requisitions'=>$requisitions]); 
    }

    public function getRequisitionsFromDateWithSupplier($from_date, $to_date, $supplier_id){
        $requisitions = RequisitionToSupplier::where('supplier_id', $supplier_id)
                        ->whereDate('requisition_date', '>=', Carbon::createFromFormat('d-m-Y', $from_date)->format('Y-m-d'))                
                        ->whereDate('requisition_date', '<=', Carbon::createFromFormat('d-m-Y', $to_date)->format('Y-m-d'))
                        ->get();  
        return response()->json(['success'=>true, 'requisitions'=>$requisitions]); 
    }

    public function getOnlyRequisition($id){
        $supplier_requisition = RequisitionToSupplier::find($id);
        $supplier_name = Supplier::find($supplier_requisition->supplier_id)->name;         
        $stockItems = SupplierStock::where('supplier_id', $supplier_requisition->supplier_id)->get(); 
        //execluding certains columns (created_at, updated_at) while using eloquent       
        $items = RequisitionIngredientList::where('requisition_to_supplier_id', $id)->get();//->makeHidden(['created_at','updated_at'])->toArray();         
        $requisition_items = [];
        $i = 0;
        foreach($items as $item){
            $requisition_items[$i]['id'] = $item->id;            
            $requisition_items[$i]['ingredient_unit'] = SupplierStock::find($item->supplier_stock_id)->ingredient->measurement_unit;
            $requisition_items[$i]['name'] = $item->name;
            $requisition_items[$i]['unit'] = $item->unit;
            $requisition_items[$i]['unit_cost'] = $item->unit_cost;
            $requisition_items[$i]['quantity'] = $item->quantity;
            $requisition_items[$i]['stock'] = $item->stock;
            $requisition_items[$i]['total'] = $item->total;
            $i++;
        }
        
        return response()->json(['success'=>true, 'supplier' => $supplier_name,'requisition'=>$supplier_requisition, 'stockItems' => $stockItems,  'requisitionItems' => $requisition_items ]); 
    }

    

    

}
