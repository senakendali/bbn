<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\DeliveryPoint;
use App\Models\ScatteredTender;
use App\Models\Cluster;
use App\Models\ClusteredTender;
use App\Models\SystemLog;
use App\Models\TenderLog;
use App\Http\Requests;
use App\Models\Province;
use App\Models\Regencies;
use App\Models\CentralizedParticipant;
use App\Models\ScatteredParticipant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Exports\OrdersExport;
use App\Exports\OrdersExportView;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


class TenderController extends Controller
{
    public function index()
    {
        return view('admin.tenders.index', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Tenders"
        ]);
    }

    public function create()
    {
        return view('admin.tenders.'.Session::get('method'), [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Tenders"
        ]);
    }

    public function publish(Request $request)
    {
        $tender_log['tender_id'] = $request->tender_id;
        $tender_log['tender_log'] = "Open for Submissions";
        $tender_log['description'] = "Tender status has been set to Open for Submissions, Tender ID: ".$request->tender_id;
        $tender_log['user_created'] = auth()->user()->name;
        TenderLog::create($tender_log);

        $system['user_name'] = auth()->user()->name;
        $system['activity'] = "Set tender status to Open for Submissions, Tender ID: ".$request->tender_id;
        $system['page'] = "Create Tender";
        SystemLog::create($system);

        Tender::where('tender_id', '=', $request->tender_id)->update(array('status' => 'Open for Submissions'));

        return redirect()->back()->with('message','The tender has been published !');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'tender_number' => 'required',
            'bbn_quota' => 'required',
            'currency' => 'required',
            'year' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'closing_date' => 'required',
            'description' => 'required'
        ]);

        $request->merge([
            'bbn_quota' => str_replace(',','',$request['bbn_quota']),
            'date_start' => Carbon::createFromFormat('d-m-Y', $request->date_start)->toDateString(),
            'date_end' => Carbon::createFromFormat('d-m-Y', $request->date_end)->toDateString(),
            'closing_date' => Carbon::createFromFormat('d-m-Y', $request->closing_date)->toDateString()
        ]);
        
        
        Tender::create($request->all());

        $tender_log['tender_id'] = $request->tender_id;
        $tender_log['tender_log'] = "Tender Setup";
        $tender_log['description'] = "Tender has been setup with Tender ID: ".$request->tender_id;
        $tender_log['user_created'] = auth()->user()->name;
        TenderLog::create($tender_log);

        $system['user_name'] = auth()->user()->name;
        $system['activity'] = "Create New Tender, Tender ID: ".$request->tender_id;
        $system['page'] = "Create Tender";
        SystemLog::create($system);

        if($request['method'] == 'scattered'){

            $delivery_point_id = $request->delivery_point_id;
            $quota = $request->quota;
           
            foreach($delivery_point_id as $key => $no)
            {
                $input['tender_id'] = $request->tender_id;
                $input['delivery_point_id'] = $no;
                $input['bbn_quota'] = str_replace(',','',$quota[$key]);

                ScatteredTender::create($input);

            }
        }


        

        return json_encode(array(
            "statusCode"=>200
        ));
    }

    public function storeCluster(Request $request)
    { 
        $input['tender_id'] = $request->tender_id;
        $input['name'] = $request->cluster_name;
        $input['quota'] = str_replace(',','',$request->cluster_quota);
        
        $cluster = Cluster::create($input);
        $cluster_id = $cluster->id;


        $delivery_point_id = $request->delivery_point_id;
        $quota = $request->quota;
        

        foreach($delivery_point_id as $key => $no)
        {
            $input['tender_id'] = $request->tender_id;
            $input['cluster_id'] = $cluster_id;
            $input['delivery_point_id'] = $no;
            
            $input['bbn_quota'] = str_replace(',','',$quota[$key]);

            ClusteredTender::create($input);

        }


        $tender_log['tender_id'] = $request->tender_id;
        $tender_log['tender_log'] = "Create Cluster";
        $tender_log['description'] = "Cluster has been created, Tender ID: ".$request->tender_id;
        $tender_log['user_created'] = auth()->user()->name;
        TenderLog::create($tender_log);

        $system['user_name'] = auth()->user()->name;
        $system['activity'] = "Create New Cluster, Tender ID: ".$request->tender_id;
        $system['page'] = "Create Cluster";
        SystemLog::create($system);

        return json_encode(array(
            "statusCode"=>200
        ));
    }

    public function storeDeliveryPoint(Request $request){
        $delivery_point_id = $request->delivery_point_id;
        $quota = $request->quota;
       

        foreach($delivery_point_id as $key => $no)
        {
            $input['tender_id'] = $request->tender_id;
            $input['delivery_point_id'] = $no;
            $input['bbn_quota'] = str_replace(',','',$quota[$key]);

            ScatteredTender::create($input);

        };

        $tender_log['tender_id'] = $request->tender_id;
        $tender_log['tender_log'] = "Add Delivery Point";
        $tender_log['description'] = "Add Delivery Point, Tender ID: ".$request->tender_id;
        $tender_log['user_created'] = auth()->user()->name;
        TenderLog::create($tender_log);

        $system['user_name'] = auth()->user()->name;
        $system['activity'] = "Add Delivery Point, Tender ID: ".$request->tender_id;
        $system['page'] = "Add Delivery Point";
        SystemLog::create($system);

        return json_encode(array(
            "statusCode"=>200
        ));
    }
    
    public function showTender(){
        $data = Tender::where('status', 'Open for Submissions')->get();


        /*$data = Tender::addSelect(['*' => CentralizedParticipant::select('vendor_id')
            ->whereColumn('tender_id', 'destinations.id')
            ->orderBy('arrived_at', 'desc')
            ->limit(1)
        ])->get();*/

        $new_data = array();
        if($data){
            foreach($data as $dt){
                $new_data[] = array(
                    'tender_id' => $dt->tender_id,
                    'tender_number'=> $dt->tender_number,
                    'method' => $dt->method,
                    'bbn_quota' => $dt->bbn_quota,
                    'is_join' => $this->checkVendorInCentralizedParticipants($dt->tender_id, auth()->user()->company_id)
                );
            }
            $response = array('status' => 200, 'data'=> $new_data);
        }else{
            $response = array('status' => 204, 'data'=> ''); 
        }
        
        
        return response()->json($response);
    }


    public function checkVendorInCentralizedParticipants($tender_id, $company_id){
        $data = CentralizedParticipant::where([
            'tender_id' => $tender_id,
            'vendor_id' => $company_id
         ])->first();
        

         if($data){
            return 'yes';
         }else{
            return 'no';
         }
        
    }

    public function getDetailOfferingInCentralizedParticipants($tender_id, $company_id){
        $data = CentralizedParticipant::where([
            'tender_id' => $tender_id,
            'vendor_id' => $company_id
         ])->first();
        

         return $data;
        
    }
   

    public function show(){
        $data = Tender::where('method', Session::get('method'))->get();
        return response()->json($data);
    }

    public function view($tender_id){
        return view('admin.tenders.'.Session::get('method').'-detail', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Tender Detail"
        ]);
    }

    public function view_centralized_submissions($tender_id){
        return view('admin.tenders.centralized_submissions', [
            "title" => "BBN E-BIDDING",
            "sub_title" => "Tender Submissions"
        ]);
    }

    public function getCentralizedBid($tender_id){
        $data = CentralizedParticipant::join('producers', 'table_centralized_participants.vendor_id', '=', 'producers.id') ->where('table_centralized_participants.tender_id', $tender_id)->orderBy('table_centralized_participants.offered_price', 'ASC')->get();
        return response()->json($data); 
    }

    public function getDetail($tender_id){
        $data = Tender::where('tender_id', $tender_id)->first();

        if($data->method == 'centralized'){
            $detail = $this->getDetailOfferingInCentralizedParticipants($data->tender_id, auth()->user()->company_id);
            $data['is_join'] = $this->checkVendorInCentralizedParticipants($data->tender_id, auth()->user()->company_id);
            $data['detail'] = array('offered_volume' => ($detail->offered_volume ?? ''), 'offered_price' => ($detail->offered_price ?? ''));
       
       
        }

       
        return response()->json($data); 
    }

    public function getTenderLogs($tender_id){
        $data = TenderLog::where('tender_id', $tender_id)->get();
        
        return response()->json($data); 
    }

    public function getDeliveryPoint($tender_id){
       
        $data = ScatteredTender::join('delivery_points', 'scattered_tenders.delivery_point_id', '=', 'delivery_points.id')->get();
       
        return response()->json($data); 
    }

    public function getCluster($tender_id){

        $data = DB::table('clustered_tenders')
                ->join('clusters', 'clusters.id', '=', 'clustered_tenders.cluster_id')
                ->join('delivery_points', 'delivery_points.id', '=', 'clustered_tenders.delivery_point_id')
                ->where('clustered_tenders.tender_id', '=', $tender_id)
                ->orderBy('clustered_tenders.cluster_id', 'ASC')
                ->orderBy('clustered_tenders.delivery_point_id', 'ASC')
                ->get();
        return response()->json($data);  
    }

    public function showDeliveryPointByCluster($cluster_id){
        $data = ClusteredTender::join('delivery_points', 'clustered_tenders.delivery_point_id', '=', 'delivery_points.id') ->where('clustered_tenders.cluster_id', $cluster_id)->get();
        return response()->json($data); 
    }

    public function showDeliveryPointByTender($tender_id){
        $data = ScatteredTender::join('delivery_points', 'scattered_tenders.delivery_point_id', '=', 'delivery_points.id')->where('scattered_tenders.tender_id', $tender_id)->get();
       // $data['is_joined'] = 'no';
        $scattered_tender = array();
        if($data){
            foreach($data as $dt){
                //$detail = $this->getDetailOfferingInScatteredParticipants($dt->id, auth()->user()->company_id, $dt->delivery_point_id);
                $scattered_tender[] = array(
                    'id' => $dt->id,
                    'delivery_point_id' => $dt->delivery_point_id,
                    'delivery_point' => $dt->delivery_point,
                    'bbn_quota' => $dt->bbn_quota,
                    'is_join' => $this->checkVendorInScatteredParticipants($dt->id, auth()->user()->company_id, $dt->delivery_point_id),
                    'detail' => array('offered_volume' => 0, 'offered_price' => 0)
                    
                );
            }
        }
        return response()->json($scattered_tender);   
    }


    public function getAppliedDeliveryPointByTender($tender_id){
        $data = ScatteredTender::join('delivery_points', 'scattered_tenders.delivery_point_id', '=', 'delivery_points.id')->where('scattered_tenders.tender_id', $tender_id)->get();
       // $data['is_joined'] = 'no';
        $scattered_tender = array();
        if($data){
            foreach($data as $dt){
                $detail = $this->getDetailOfferingInScatteredParticipants($dt->id, auth()->user()->company_id, $dt->delivery_point_id);
                $scattered_tender[] = array(
                    'id' => $dt->id,
                    'delivery_point_id' => $dt->delivery_point_id,
                    'delivery_point' => $dt->delivery_point,
                    'bbn_quota' => $dt->bbn_quota,
                    'is_join' => $this->checkVendorInScatteredParticipants($dt->id, auth()->user()->company_id, $dt->delivery_point_id),
                    'detail' => array('offered_volume' => ($detail->offered_quota ?? ''), 'offered_price' => ($detail->offered_price ?? ''))
                    
                );
            }

            
        }
        return response()->json($scattered_tender);   
    }

    public function checkVendorInScatteredParticipants($scattered_id, $company_id, $delivery_point_id){
        $data = ScatteredParticipant::where([
            'scattered_id' => $scattered_id,
            'vendor_id' => $company_id,
            'delivery_point_id' => $delivery_point_id
         ])->first();

         if($data){
            return 'yes';
         }else{
            return 'no';
         }
        
    }

    public function getDetailOfferingInScatteredParticipants($scattered_id, $company_id, $delivery_point_id){
        $data = ScatteredParticipant::where([
            'scattered_id' => $scattered_id,
            'vendor_id' => $company_id,
            'delivery_point_id' => $delivery_point_id
         ])->first();
        
         //echo $scattered_id.'-'.$company_id.'-'.$delivery_point_id;
         //echo '<pre>'; print_r($data);
         //exit;
         return $data;
    }

    public function chooseDeliveryPointForCluster($tender_id){
        $delivery_point_id = DB::table('clustered_tenders')->select('delivery_point_id')->where('tender_id', $tender_id);

        $data = DB::table('delivery_points')
                ->whereNOTIn('id', $delivery_point_id)
                ->get();
        return response()->json($data);
    }

    public function ExportToExcel(){
        return Excel::download(new OrdersExportView, 'data-pre-order.xlsx');
    }

}
