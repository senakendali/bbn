<?php

namespace App\Http\Controllers;

use App\Models\DeliveryPoint;
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

class DeliveryPointController extends Controller
{
    public function index()
    {
        return view('admin.delivery_point.index', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Delivery Point"
        ]);
    }

    public function create()
    {
        return view('admin.delivery_point.form', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Delivery Point"
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'delivery_point' => 'required',
            'delivery_point_province_id' => 'required'
        ]);

        DeliveryPoint::create($request->all());
        return json_encode(array(
            "statusCode"=>200
        ));
    }

    public function show($province_id = ''){
       
        if($province_id){
            $data = DeliveryPoint::where('delivery_point_province_id', $province_id)->get();   
        }else{
            $data = DeliveryPoint::all()->sortByDesc("id");
        }
        return response()->json($data);
    }

    public function ExportToExcel(){
        //return Excel::download(new OrdersExport, 'data-pre-order.xlsx');
        return Excel::download(new OrdersExportView, 'data-pre-order.xlsx');
    }

}
