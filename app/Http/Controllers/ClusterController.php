<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
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

class ClusterController extends Controller
{
    public function index()
    {
        return view('admin.cluster.index', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Cluster"
        ]);
    }

    public function create()
    {
        return view('admin.cluster.form', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Cluster"
        ]);
    }

    public function ExportToExcel(){
        //return Excel::download(new OrdersExport, 'data-pre-order.xlsx');
        return Excel::download(new OrdersExportView, 'data-pre-order.xlsx');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required'
        ]);

        Cluster::create($request->all());
        return json_encode(array(
            "statusCode"=>200
        ));
    }

    public function show(){
        $data = Cluster::all()->sortByDesc("id");
        return response()->json($data);
    }

}
