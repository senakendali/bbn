<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    //protected $fillable = ['transaction_id', 'id', 'nama'];
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at'];
    
    use HasFactory;

    public static function get_orders()
    {
        $orders = DB::table('order')->orderBy('id')->get();
        return collect($orders);
    }

    public static function get_detail_order($kode_transaksi)
    {
        $order_detail = DB::table('orders')
            ->select('orders.*', 'provinces.name AS provinsi', 'regencies.name AS kota')
            ->leftJoin('provinces', 'orders.province_id', '=', 'provinces.id')
            ->leftJoin('regencies', 'orders.regency_id', '=', 'regencies.id')
            ->where('orders.transaction_id', '=', $kode_transaksi)
            ->first();


            
        return $order_detail;
    }

    public static function udapte_payment_status($kode_transaksi){
        $affected = DB::table('orders')
        ->where('transaction_id', $kode_transaksi)
        ->update(['payment_status' => 1]);

        if($affected){
            return true;
        }
    }

    public static function get_total_order_by_province(){

        //$reserves = DB::table('reserves')->select(DB::raw('*, count(*)'))->groupBy('day')->get();


        $total_orders = DB::table('orders')
        ->select(DB::raw('provinces.name AS provinsi, count(*) as total'))
        ->orderBy('total', 'desc')
        ->groupBy('provinsi')
        ->leftJoin('provinces', 'orders.province_id', '=', 'provinces.id')
        ->first();

        return $total_orders;
    }

    public static function get_transaction_data(){
        $data = DB::table('orders')
            ->select('orders.*', 'provinces.name AS provinsi', 'regencies.name AS kota')
            ->leftJoin('provinces', 'orders.province_id', '=', 'provinces.id')
            ->leftJoin('regencies', 'orders.regency_id', '=', 'regencies.id')
            ->orderBy('orders.id', 'desc')
            ->get()->toArray();

        return $data;
    }

    public static function get_total_order_by_cities(){

        //$reserves = DB::table('reserves')->select(DB::raw('*, count(*)'))->groupBy('day')->get();


        $total_orders = DB::table('orders')
        ->select(DB::raw('regencies.name AS city, count(*) as total'))
        ->orderBy('total', 'desc')
        ->groupBy('city')
        ->leftJoin('regencies', 'orders.regency_id', '=', 'regencies.id')
        ->first();

        return $total_orders;
    }

    public static function get_total_by_payment_status($status){

        //$reserves = DB::table('reserves')->select(DB::raw('*, count(*)'))->groupBy('day')->get();


        $total_orders = DB::table('orders')
        ->select(DB::raw('count(*) as total'))
        ->where('payment_status', $status)
        ->first();

        return $total_orders;
    }
    
        
    
}
