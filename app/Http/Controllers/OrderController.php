<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests;
use App\Models\Province;
use App\Models\Regencies;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        return view('order', [
            "title" => "Bravo Senapati",
            "sub_title" => "Purchase Order",
            "provinces" => Province::all()
        ]);
    }

    public function midtrans(){

        //SAMPLE REQUEST START HERE

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'customer_details' => array(
                'first_name' => 'budi',
                'last_name' => 'pratama',
                'email' => 'budi.pra@example.com',
                'phone' => '08111222333',
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        

        return view('midtrans', [
            "title" => "Bravo Senapati",
            "sub_title" => "Order Confirmation",
            "detail" => Order::get_detail_order('05798f68-1341-4b49-a777-48f6e50c64b7'),
            "snap_token" => $snapToken
        ]); 
    }

    public function show($transaction_no, $snapToken)
    {
        return view('confirm', [
            "title" => "Bravo Senapati",
            "sub_title" => "Order Confirmation",
            "detail" => Order::get_detail_order($transaction_no)
        ]);
    }

    public function DetailOrder($transaction_no)
    {
        return view('order_detail',  [
            "title" => "Bravo Senapati",
            "sub_title"=> "Order Detail",
            "detail" => Order::get_detail_order($transaction_no)
        ]);  
    }

    public function status($transaction_no)
    {
        /*if($_GET['status'] == 200){
            Order::udapte_payment_status($transaction_no);
        }*/
       

        return view('status',  [
            "title" => "Bravo Senapati",
            "sub_title"=> "Payment Status",
            "detail" => Order::get_detail_order($transaction_no)
        ]);
    }

    public function get_city(Request $request)
    {
       
        $regencies = Regencies::regencies_by_province($request->input('province_id'));
        echo "<option selected>Pilih Kota</option>";
        foreach($regencies as $regency)
        {
            echo "<option value='".$regency->id."'>".$regency->name."</option>";
        }
    }

    function submit(Request $request){
        $validatedData = $request->validate([
            'transaction_id' => 'required|unique:orders',
            'nama' => 'required',
            'email' => 'required|email',
            'hp' => 'required',
            'alamat' => 'required',
            'province_id' => 'required',
            'regency_id' => 'required',
            'ktp' => 'required'
            
            
        ]);

       

        $folder_destination = 'document';
        $file = $request->file('ktp');
        $file->move($folder_destination,$file->getClientOriginalName());

        $validatedData['id'] = date('YmdHis');
        $validatedData['ktp'] = $file->getClientOriginalName();

        Order::create($validatedData);

        /*Install Midtrans PHP Library (https://github.com/Midtrans/midtrans-php)
        composer require midtrans/midtrans-php
                                    
        Alternatively, if you are not using **Composer**, you can download midtrans-php library 
        (https://github.com/Midtrans/midtrans-php/archive/master.zip), and then require 
        the file manually.   

        require_once dirname(__FILE__) . '/pathofproject/Midtrans.php'; */

        //SAMPLE REQUEST START HERE

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $request->input('transaction_id'),
                'gross_amount' => 100000,
            ),
            'customer_details' => array(
                'name' => $request->input('nama'),
                'email' => $request->input('email'),
                'phone' => $request->input('hp'),
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $transaction_no = $request->input('transaction_id');
        $detail = Order::get_detail_order($transaction_no);
        $title = "Bravo Senapati";
        $sub_title =  "Purchase Order";
        return redirect('/confirm/'.$request->input('transaction_id').'/'.$snapToken);
        //return view('confirm', compact('snapToken', 'transaction_no', 'detail', 'title', 'sub_title'));
        
    }

    public function update_payment_status(Request $request){
        $order = Order::find($request->order_id);
        //$order->update("payment_status" => 1);
    }

    public function callback(Request $request){
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key){
            if($request->transaction_status == 'capture'){
               
                $order = Order::find($request->order_id);
                Order::udapte_payment_status($request->order_id);
               
            }
        }

       
    }
}
