<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Models\Province;
use App\Models\Regencies;
use App\Models\Producer;
use App\Models\SupplyPoint;
use App\Models\CentralizedParticipant;
use App\Models\ScatteredParticipant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResourcesController extends Controller
{
    public function getProvinces(){
        $provinces = Province::all();
        return response()->json($provinces);
    }

    public function getRegencies(Request $request)
    {
        $data = Regencies::regencies_by_province($request->input('province_id'));
        return response()->json($data);
    }

    public function getSupplyPoint()
    {
        
        $data = SupplyPoint::all();
        return response()->json($data);  
    }

    public function getCompanyDetail($company_id){
       $data = Producer::join('supply_points', 'producers.supply_point_id', '=', 'supply_points.id') ->where('producers.id', $company_id)->first();
        
       $data['total_alocated'] = array(
            'centralized_offered_volume' => $this->getSummaryCentralizedTender($company_id), 
            'scattered_offered_volume' => $this->getSummaryScatteredTender($company_id), 
            'clustered_offered_volume' => 0,
            'total_offered_volume' => ($this->getSummaryCentralizedTender($company_id) + $this->getSummaryScatteredTender($company_id))
        );


        $response = array('status' => 200, 'data'=> $data);
        
        return response()->json($response); 

    }

    public function getSummaryCentralizedTender($company_id){
        $data = CentralizedParticipant::where([
            'vendor_id' => $company_id
         ])->sum('offered_volume');
        
       

         return $data;
    }

    public function getSummaryScatteredTender($company_id){
        $data = ScatteredParticipant::where([
            'vendor_id' => $company_id
         ])->sum('offered_quota');
        
       

         return $data;
    }

    
}
