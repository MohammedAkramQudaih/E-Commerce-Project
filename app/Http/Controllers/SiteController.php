<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        // $category=Category::all();
        $pro=Product::latest()->limit(5)->get();
        $product=Product::all();
        return view('website.index', compact('product','pro'));
    }

    public function category($id)
    {
        $category=Category::where('slug',$id)->first();

        // return view('website.category')->with('category','$category');
        return view('website.category', compact('category'));
    }
}
