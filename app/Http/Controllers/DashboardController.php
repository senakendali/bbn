<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Http\Requests;
use App\Models\Province;
use App\Models\Regencies;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Exports\OrdersExport;
use App\Exports\OrdersExportView;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.dashboard_type', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Dashboard"
        ]);
    }

    public function choose(){
        return view('admin.dashboard.dashboard_type', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Dashboard"
        ]); 
    }

    public function setDashboardType(Request $request){
        $validate = $request->validate([
            'method' => 'required'
        ]);

        Session::put('method', $request['method']);

        return json_encode(array(
            "statusCode"=>200,
            "redirect"=> url('tenders')
        ));
    }

    public function ExportToExcel(){
        //return Excel::download(new OrdersExport, 'data-pre-order.xlsx');
        return Excel::download(new OrdersExportView, 'data-pre-order.xlsx');
    }

}
