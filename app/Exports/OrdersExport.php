<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class OrdersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return Order::all();
        $data = DB::table('orders')
            ->select('orders.*', 'provinces.name AS provinsi', 'regencies.name AS kota')
            ->leftJoin('provinces', 'orders.province_id', '=', 'provinces.id')
            ->leftJoin('regencies', 'orders.regency_id', '=', 'regencies.id')
            ->orderBy('orders.id', 'desc')
            ->get();


        return $data;
    }
}
