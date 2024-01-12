<?php

namespace App\Http\Controllers;

use App\Models\SupplyPoint;
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

class SupplyPointController extends Controller
{
    public function index()
    {
        return view('admin.supply_point.index', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Supply Point"
        ]);
    }

    public function create()
    {
        return view('admin.supply_point.form', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Supply Point"
        ]);
    }

    public function ExportToExcel(){
        //return Excel::download(new OrdersExport, 'data-pre-order.xlsx');
        return Excel::download(new OrdersExportView, 'data-pre-order.xlsx');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'bbu_bbn_location' => 'required',
            'province_id' => 'required'
        ]);

        SupplyPoint::create($request->all());
        return json_encode(array(
            "statusCode"=>200
        ));
    }

    public function show(){
        $data = SupplyPoint::all()->sortByDesc("id");
        return response()->json($data);
    }

}
