<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class DailyExport implements FromCollection, WithHeadings
{
    public function collection()
    {
       return DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('products.name', 'unit_price', DB::raw('SUM(product_quantity) as total_qty, unit_price * SUM(product_quantity) as subtotal')) 
            ->whereRaw('has_attribute = 0 and order_id is not NULL and order_cancel = 0 and date(carts.created_at) = CURDATE() - INTERVAL 1 DAY')
            ->groupBy('products.name', 'unit_price')
            ->orderByRaw('SUM(product_quantity) DESC')
            ->get(); 
    }

    public function headings(): array
    {
        return [
            'Food Name',
            'Unit Price',
            'Total Qty',
            'Subtotal',
        ];
    }
}