<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Ordersale;
use App\Traits\FlashMessages; 

class PosOrderController extends Controller
{
    use FlashMessages;

    public function index(){
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'POS Orders', 'subTitle' => 'List of all POS Orders' ]);
        $orders = Ordersale::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.sales.orders.index', compact('orders'));
    }
}
