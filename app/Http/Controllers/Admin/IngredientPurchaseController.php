<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Traits\FlashMessages;
use App\Models\Ingredient; 
use App\Models\IngredientPurchase;
use Carbon\Carbon;

class IngredientPurchaseController extends BaseController
{
    use FlashMessages;

    /**
     * Listing all purchases of an ingredient    
     */
    public function index($id){
        //getting the ingredient        
        $ingredient = Ingredient::find($id);
        //listing all the purchaes for the current ingredient.       
        $purchases =  IngredientPurchase::orderBy('created_at', 'DESC')->where('ingredient_id', $ingredient->id)->take(200)->get(); 
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Ingredient Purchase', 'subTitle' => 'Ingredient all purchases list' ]);
                
        return view('admin.ingredients.purchases.index', compact('purchases', 'ingredient'));  
        
    }

    public function create($id){
        //getting the ingredient        
        $ingredient = Ingredient::find($id);
        view()->share(['pageTitle' => 'Ingredient Purchase', 'subTitle' => 'Adding purchase entry for the ingredient' ]);                
        return view('admin.ingredients.purchases.create', compact('ingredient'));         
    }

    /**
     * Save the ingredient
     * @param Request $request  
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){
        
        $validated = $request->validate([
            'name' => 'required|string|max:191', 
            'quantity'  => 'required|numeric',
            'unit' => 'required|string', 
            'price'=>  'required|regex:/^\d+(\.\d{1,2})?$/',            
        ]);        
        //coverting date format from m-d-Y to Y-m-d as database stroes date in 'Y-m-d' format
        $purchase_date = Carbon::createFromFormat('d-m-Y', $request->purchase_date)->format('Y-m-d');
        $expire_date = Carbon::createFromFormat('d-m-Y', $request->expire_date)->format('Y-m-d');

        $ingredientPurchase= IngredientPurchase::create([
            'name' => $request->name,
            'ingredient_id' => $request->ingredient_id,
            'quantity' => $request->quantity,
            'price' =>   $request->price, 
            'unit' =>   $request->unit,
            'purchase_date' =>   $purchase_date,
            'expire_date' => $expire_date,
            'added_by' => auth()->user()->name,
        ]);

        //getting the ingredient details       
        $ingredient = Ingredient::find($request->ingredient_id);
        // Setting ingredient total quantity, total price, per unit cost price 
        $ingredient_total_quantity = $ingredient->total_quantity;
        $ingredient_total_price = $ingredient->total_price;
        $ingredient_measurement_unit = $ingredient->measurement_unit;
        $ingredient_smallest_unit = $ingredient->smallest_unit;        

        //increasing ingredient quantity
        if($ingredient->measurement_unit == $ingredientPurchase->unit){
            // for measuring unit Killogram or Liter
            $ingredient_total_quantity += $ingredientPurchase->quantity; 

        }elseif($ingredient_measurement_unit == 'Kg' &&  $ingredientPurchase->unit  == 'gm' ||
        $ingredient_measurement_unit == 'liter' &&  $ingredientPurchase->unit  == 'ml' ){
            // for measuring unit gram or ml
            $ingredient_total_quantity += ($ingredientPurchase->quantity/1000); 
        }
        
        // increasing total ingredient price 
        $ingredient_total_price += $ingredientPurchase->price; 
        // calculating ingredient unit price in gm or ml
        if($ingredient->measurement_unit == 'Kg' || $ingredient->measurement_unit == 'liter' ){
            $ingredient_smallest_unit_price = $ingredient_total_price /($ingredient_total_quantity * 1000);
        }else{
            $ingredient_smallest_unit_price = $ingredient_total_price/$ingredient_total_quantity;
        }

        // updating the ingredient total quatity, total price and unit price
        $ingredient->total_quantity = $ingredient_total_quantity;        
        $ingredient->total_price = $ingredient_total_price;
        $ingredient->smallest_unit_price = $ingredient_smallest_unit_price;
        $ingredient->save();        

        if($ingredientPurchase){           

            // setting flash message using trait
            $this->setFlashMessage(' Purchase item is added successfully', 'success');    
            $this->showFlashMessages(); 

            // Attaching pagetitle and subtitle to view.
            view()->share(['pageTitle' => 'Ingredient Purchase', 'subTitle' => 'Ingredient all purchases list' ]); 

            $purchases =  IngredientPurchase::orderBy('created_at', 'DESC')->where('ingredient_id', $request->ingredient_id)->take(200)->get();            

            return view('admin.ingredients.purchases.index', compact('purchases', 'ingredient'));  
        }else{
            return $this->responseRedirectBack(' Error occurred while adding an ingredient .' ,'error', false, false);    
        }

    }

    public function edit($id){
        $purchase = IngredientPurchase::find($id); 
        view()->share(['pageTitle' => 'Ingredients', 'subTitle' => 'Edit the purchase ingredient: ' . $purchase->name ]);
        $ingredient = Ingredient::find($purchase->ingredient_id); 
        return view('admin.ingredients.purchases.edit', compact('purchase', 'ingredient'));
    }

    public function update(Request $request){

        $validated = $request->validate([
            'name' => 'required|string|max:191', 
            'quantity'  => 'required|numeric',
            'unit' => 'required|string', 
            'price'=>  'required|regex:/^\d+(\.\d{1,2})?$/',            
        ]);       
      

        //Getting the ingredient purchase details.
        $ingredientPurchase = IngredientPurchase::find($request->purchase_id);
        //getting the ingredient details       
        $ingredient = Ingredient::find($ingredientPurchase->ingredient_id);           

        //decreasing ingredient quantity before the adding the updated quantity
        if($ingredient->measurement_unit == $ingredientPurchase->unit){
            // for measuring unit Killogram or Liter
            $ingredient->total_quantity -= $ingredientPurchase->quantity; 

        }elseif($ingredient->measurement_unit == 'Kg' &&  $ingredientPurchase->unit  == 'gm' ||
        $ingredient->measurement_unit == 'liter' &&  $ingredientPurchase->unit  == 'ml' ){
            // for measuring unit gram or ml
            $ingredient->total_quantity -= ($ingredientPurchase->quantity/1000); 
        }
        //decreasing ingredient price before the adding the updated ingredient_purchase price
        $ingredient->total_price -= $ingredientPurchase->price;   
        
        //coverting date format from m-d-Y to Y-m-d as database stroes date in 'Y-m-d' format
        $purchase_date = Carbon::createFromFormat('d-m-Y', $request->purchase_date)->format('Y-m-d');
        $expire_date = Carbon::createFromFormat('d-m-Y', $request->expire_date)->format('Y-m-d');

        //now updating the ingredient_purchase details.
        $ingredientPurchase->name = $request->name;
        $ingredientPurchase->quantity = $request->quantity;
        $ingredientPurchase->price = $request->price;
        $ingredientPurchase->unit = $request->unit;
        $ingredientPurchase->purchase_date =  $purchase_date;
        $ingredientPurchase->expire_date = $expire_date;
        $ingredientPurchase->save(); 

        //updating the ingredient total quatity, total price and unit price     
        if($ingredient->measurement_unit == $ingredientPurchase->unit){
            // for measuring unit Killogram or Liter
            $ingredient->total_quantity += $ingredientPurchase->quantity; 

        }elseif($ingredient->measurement_unit == 'Kg' &&  $ingredientPurchase->unit  == 'gm' ||
        $ingredient->measurement_unit == 'liter' &&  $ingredientPurchase->unit  == 'ml' ){
            // for measuring unit gram or ml
            $ingredient->total_quantity += ($ingredientPurchase->quantity/1000); 
        }
        // increasing total ingredient price 
        $ingredient->total_price += $ingredientPurchase->price; 
        // calculating ingredient unit price 
        if($ingredient->measurement_unit == 'Kg' || $ingredient->measurement_unit == 'liter' ){
            $ingredient->smallest_unit_price =  $ingredient->total_price / ($ingredient->total_quantity * 1000);
        }else{
            $ingredient->smallest_unit_price = $ingredient->total_price /$ingredient->total_quantity;
        }       
        $ingredient->save();

        if($ingredientPurchase){           

            // setting flash message using trait
            $this->setFlashMessage(' Purchase item is updated successfully', 'success');    
            $this->showFlashMessages(); 

            // Attaching pagetitle and subtitle to view.
            view()->share(['pageTitle' => 'Ingredient Purchase', 'subTitle' => 'Ingredient all purchases list' ]); 

            $purchases =  IngredientPurchase::orderBy('created_at', 'DESC')->where('ingredient_id', $ingredientPurchase->ingredient_id)->take(200)->get();            

            return view('admin.ingredients.purchases.index', compact('purchases', 'ingredient'));  
        }else{
            return $this->responseRedirectBack(' Error occurred while updating the ingredient purchase .' ,'error', false, false);    
        }

    }

    public function delete($id){
        $ingredientPurchase = IngredientPurchase::find($id);
        //before deleting the purchase record, we need to substract the total quantity and total price from ingredient stock. and also recalculate the per unit cost.

        //getting the ingredient details       
        $ingredient = Ingredient::find($ingredientPurchase->ingredient_id);           

        //decreasing ingredient quantity before the deleting 
        if($ingredient->measurement_unit == $ingredientPurchase->unit){
            // for measuring unit Killogram or Liter
            $ingredient->total_quantity -= $ingredientPurchase->quantity; 

        }elseif($ingredient->measurement_unit == 'Kg' &&  $ingredientPurchase->unit  == 'gm' ||
        $ingredient->measurement_unit == 'liter' &&  $ingredientPurchase->unit  == 'ml' ){
            // for measuring unit gram or ml
            $ingredient->total_quantity -= ($ingredientPurchase->quantity/1000); 
        }
        //decreasing ingredient price before the adding the updated ingredient_purchase price
        $ingredient->total_price -= $ingredientPurchase->price;   
        // recalculate the per unit cost of the ingredient 
        if($ingredient->measurement_unit == $ingredient->smallest_unit){ 

            $ingredient->smallest_unit_price = $ingredient->total_price / $ingredient->total_quantity; 

        }elseif($ingredient->measurement_unit != $ingredient->smallest_unit){

            $ingredient->smallest_unit_price = $ingredient->total_price / ($ingredient->total_quantity*1000);   
        }
        
        $ingredient->save();
      
        $ingredientPurchase->delete();

        if(!$ingredientPurchase){
            return  $this->responseRedirectBack(' Error occurred while deleting the category.', 'error', true, true);
        }
        $this->setFlashMessage(' Ingredient purchase record is deleted successfully', 'success');    
        $this->showFlashMessages();
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Ingredient Purchase', 'subTitle' => 'Ingredient all purchases list' ]); 
        $purchases =  IngredientPurchase::orderBy('created_at', 'DESC')->where('ingredient_id', $ingredient->id)->take(200)->get();            

        return view('admin.ingredients.purchases.index', compact('purchases', 'ingredient'));        

    }

  
}
