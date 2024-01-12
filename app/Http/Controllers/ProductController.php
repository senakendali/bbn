<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        return view('product', [
            "title" => "Bravo Senapati",
            "sub_title"=> "Product Detail"
        ]);
    }
}
