<?php

namespace App\Http\Controllers;
use App\Models\Producer;
use App\Models\User;
use App\Models\CentralizedParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
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

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('login', true);
            Session::put('is_vendor_login', true);
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/vendors/login');
    }

   

    public function submitRegistrationData(Request $request)
    {
        $validate = $request->validate([
            'company_name' => 'required',
            'company_address' => 'required',
            'factory_address' => 'required',
            'production_capacity' => 'required',
            'province_id' => 'required',
            'regencie_id' => 'required',
            'supply_point_id' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'confirm-password' => 'required|same:password'
            
        ]);

        $request->merge([
            'production_capacity' => str_replace(',','',$request['production_capacity'])
        ]);

        
        //$request['name'] = $request['company_name'];
        $vendor = Producer::create($request->all());
        $vendor_id = $vendor->id;
        //$company_id = $cluster->id;


        $data = $request->except('confirm-password', 'password');
        $data['password'] = Hash::make($request->password);
        $data['company_id'] = $vendor_id;
        $data['group'] = 3;
       

       
        User::create($data);


        return json_encode(array(
            "statusCode"=>200
        ));
    }
}
