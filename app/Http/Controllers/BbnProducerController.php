<?php

namespace App\Http\Controllers;

use App\Models\Producer;
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

class BbnProducerController extends Controller
{
    public function index()
    {
        return view('admin.bbn_producer.index', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Delivery Point",
            "tenders" => Producer::all()->sortByDesc("id")
        ]);
    }

    public function create()
    {
        return view('admin.bbn_producer.form', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Delivery Point"
        ]);
    }

    public function ExportToExcel(){
        //return Excel::download(new OrdersExport, 'data-pre-order.xlsx');
        return Excel::download(new OrdersExportView, 'data-pre-order.xlsx');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'production_capacity' => 'required',
            'province_id' => 'required',
            'regencie_id' => 'required'
            
        ]);

        $request->merge([
            'production_capacity' => str_replace(',','',$request['production_capacity']),
        ]);

        Producer::create($request->all());
        return json_encode(array(
            "statusCode"=>200
        ));
    }

    public function show(){
        $producer = Producer::all()->sortByDesc("id");
        return response()->json($producer);
    }

}
