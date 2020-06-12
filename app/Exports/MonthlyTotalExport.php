<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class MonthlyTotalExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        //Month wise sale reports 
       return DB::table('carts')
            ->select( DB::raw('DATE_FORMAT(created_at, "%Y-%m") as yearMonth, SUM(product_quantity * unit_price ) as subtotal')) 
            ->whereRaw('has_attribute = 0 and order_id is not NULL and order_cancel = 0')
            ->groupByRaw('DATE_FORMAT(created_at, "%Y-%m")')         
            ->orderByRaw('DATE_FORMAT(created_at, "%Y-%m") DESC')
            ->get();
       
    }

    public function headings(): array
    {
        return [
            'Year-Month',
            'Total Amount(Tk)',  
        ];
    }
}