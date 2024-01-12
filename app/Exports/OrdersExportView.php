<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class OrdersExportView implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        return view('orders-data', [
            'orders' => Order::get_transaction_data()
        ]);
    }
}
