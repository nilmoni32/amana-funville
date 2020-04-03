<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Contracts\CategoryContract;
use App\Contracts\ProductContract;
use App\Http\Requests\StoreProductFormRequest;

class ProductController extends BaseController
{
    protected $categoryRepository;
    protected $productRepository;

    public function __construct(CategoryContract $categoryRepository, ProductContract $productRepository){

        $this->productRepository =  $productRepository;
        $this->categoryRepository = $categoryRepository;
    }
    
    public function index(){

        $products = $this->productRepository->listProducts(); // getting all the products using repository pattern technique.
        $this->setPageTitle('Food Menu', 'List of Food items'); // Attaching title and subtitle using BaseController setPageTitle function.        
        return view('admin.products.index', compact('products')); // returning the admin.products.index view with products     

    }

    public function create(){
        $categories = $this->categoryRepository->listCategories('category_name','asc'); // fetching all categories name with ascending order.
        $this->setPageTitle('Food Menu', 'Add Food item');
        return view('admin.products.create', compact('categories'));
    }

    
    public function store(Request $request){
        // Instead of using Illuminate\Http\Request class, we are using StoreProductFormRequest class
        // validation logic is done by laravel form request app/Http/Requests

        if($request->discount_price){
            $this->validate($request,[                       
                'name'               =>  'required|max:191',
                'price'              =>  'required|regex:/^\d+(\.\d{1,2})?$/',
                'discount_price'     =>  'regex:/^\d+(\.\d{1,2})?$/',  
            ]);   
        }  
        else{
            $this->validate($request,[                       
                'name'               =>  'required|max:191',
                'price'              =>  'required|regex:/^\d+(\.\d{1,2})?$/',                  
            ]);
        }             

        $params = $request->except('_token'); // getting all inputs
        $product = $this->productRepository->createProduct($params);
        
        if (!$product) {
            return $this->responseRedirectBack('Error occurred while creating product.', 'error', true, true);
        }
        return $this->responseRedirect('admin.products.index', ' Product is added successfully' ,'success',false, false);
    }

    public function edit($id){
        // loading the editable product using the findProductById() method of product repository then loadin the edit view.
        $product = $this->productRepository->findProductById($id);
        // loading all categories name
        $categories = $this->categoryRepository->listCategories('category_name', 'asc');

        $this->setPageTitle('Food Menu', ' Edit Food item: '.$product->name);       
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request){

        if($request->discount_price){
            $this->validate($request,[                       
                'name'               =>  'required|max:191',
                'price'              =>  'required|regex:/^\d+(\.\d{1,2})?$/',
                'discount_price'     =>  'regex:/^\d+(\.\d{1,2})?$/',  
            ]);   
        }  
        else{
            $this->validate($request,[                       
                'name'               =>  'required|max:191',
                'price'              =>  'required|regex:/^\d+(\.\d{1,2})?$/',                  
            ]);
        }        

        $params = $request->except('_token'); // getting all the inputs
        $product = $this->productRepository->updateProduct($params);

        if (!$product) {
            return $this->responseRedirectBack('Error occurred while updating product.', 'error', true, true);
        }
        return $this->responseRedirect('admin.products.index', ' Product updated successfully' ,'success',false, false);
    }

    public function delete($id){

        $product = $this->productRepository->deleteProduct($id);

        if (!$product) {
            return $this->responseRedirectBack('Error occurred while deleting product.', 'error', true, true);
        }
        return $this->responseRedirect('admin.products.index', ' Product deleted successfully' ,'success',false, false);
    }
}
