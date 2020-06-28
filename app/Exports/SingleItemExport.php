<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Product;


class SingleItemExport implements FromCollection, WithHeadings
{
    protected $start_date, $end_date, $search;

    public function __construct(string $start_date, string $end_date, string $search)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->search = $search;
    }

    public function collection()
    {
        $product = Product::where('name', 'like', '%'.$this->search.'%')->first();
        //single item sale reports 
        return DB::table('carts')
                ->join('products', 'carts.product_id', '=', 'products.id')
                ->leftJoin('product_attributes', 'carts.product_attribute_id', '=', 'product_attributes.id')
                ->select(DB::raw('Date(carts.created_at) as date, products.name, product_attributes.size, unit_price, SUM(product_quantity) as total_qty, unit_price * SUM(product_quantity) as subtotal')) 
                ->whereRaw('order_id is not NULL and order_cancel = 0')
                ->whereBetween('carts.created_at', [$this->start_date, $this->end_date])
                ->where('carts.product_id', $product->id)
                ->groupByRaw('Date(carts.created_at), products.name, product_attributes.size, unit_price')
                ->orderByRaw('Date(carts.created_at) DESC')
                ->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'Food Name',
            'Size',
            'Unit Price',
            'Total Qty',
            'Subtotal',
        ];
    }
}