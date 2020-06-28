<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ItemBasedExport implements FromCollection, WithHeadings
{
    protected $start_date, $end_date;

    public function __construct(string $start_date, string $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        return DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->leftJoin('product_attributes', 'carts.product_attribute_id', '=', 'product_attributes.id')
            ->select('products.name', 'product_attributes.size','unit_price', DB::raw('SUM(product_quantity) as total_qty, unit_price * SUM(product_quantity) as subtotal')) 
            ->whereRaw('order_id is not NULL and order_cancel = 0')
            ->whereBetween('carts.created_at', [$this->start_date, $this->end_date])
            ->groupBy('products.name','product_attributes.size','unit_price')
            ->orderByRaw('SUM(product_quantity) DESC')
            ->get();  
        
           
    }

    public function headings(): array
    {
        return [
            'Food Name',
            'Size',
            'Unit Price',
            'Total Qty',
            'Subtotal',
        ];
    }
}