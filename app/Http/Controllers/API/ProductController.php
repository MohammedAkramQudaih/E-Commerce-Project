<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        if (request()->api_key == env('API_KEY')) {
            return Product::all();
        }else
            return response(['data'=>'You are not allowed see']);
       
    }
    public function login(Request $request)
    {
        dd($request->all());  
    }
}
