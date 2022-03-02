<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use Carbon\Carbon;
use App\Models\Ingredient;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Traits\FlashMessages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class SupplierController extends BaseController
{
    use FlashMessages;
    public function index(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Suppliers', 'subTitle' => 'List of all Suppliers' ]);
        $suppliers = Supplier::orderBy('created_at', 'desc')->paginate(30);
        return view('admin.supplier.index', compact('suppliers'));
    }
}
