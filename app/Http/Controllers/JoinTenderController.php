<?php

namespace App\Http\Controllers;
use App\Models\Producer;
use App\Models\User;
use App\Models\CentralizedParticipant;
use App\Models\ScatteredParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class JoinTenderController extends Controller
{
    public function index(){
        return view('main.home', [
            "title" => "Home",
            "sub_title"=> "BBN"
        ]);
    }

    public function registration(){
        return view('main.registration', [
            "title" => "Vendors Registration",
            "sub_title"=> "BBN"
        ]);
    }

    public function login(){
        return view('main.login', [
            "title" => "Vendors Login",
            "sub_title"=> "BBN"
        ]);
    }

    public function apply($tender_id){
        return view('main.apply', [
            "title" => "Submit Quotation",
            "sub_title"=> "BBN"
        ]);
    }

    

   

    public function submitQuotation(Request $request)
    {
        if($request['method'] == 'centralized'){
            $validate = $request->validate([
                'tender_id' => 'required',
                'offered_volume' => 'required',
                'offered_price' => 'required'
                
            ]);

            $request->merge([
                'offered_volume' => str_replace(',','',$request['offered_volume'])
            ]);

            $request->merge([
                'offered_price' => str_replace(',','',$request['offered_price'])
            ]);

            $request->merge([
                'vendor_id' => auth()->user()->company_id
            ]);

            $request->merge([
                'user_created' => auth()->user()->name
            ]);

            CentralizedParticipant::create($request->all());

        }else if($request['method'] == 'scattered'){
            $scattered_id = $request->scattered_id;
            $delivery_point_id = $request->delivery_point_id;
            $offered_quota = $request->offered_quota;
            $offered_price = $request->offered_price;
            
            
            foreach($scattered_id as $key => $no)
            {
                $input['scattered_id'] = $no;
                $input['tender_id'] = $request->tender_id;
                $input['delivery_point_id'] = $delivery_point_id[$key];
                $input['vendor_id'] = auth()->user()->company_id;
                $input['offered_quota'] = str_replace(',','',$offered_quota[$key]);
                $input['offered_price'] = str_replace(',','',$offered_price[$key]);
                $input['user_created'] = auth()->user()->name;

                
                
                if($input['offered_quota'] && $input['offered_price']){
                    ScatteredParticipant::create($input);
                }
                

            }
            
            
        }

        
        
        /*return json_encode(array(
            "statusCode"=>200
        ));*/
    }
}
