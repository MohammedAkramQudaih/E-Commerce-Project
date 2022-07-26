<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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

    public function product($slug)
    {
        $product = Product::where('slug',$slug)->first();
        return view('website.product',compact('product'));
    }

    public function buy(Request $request)
    {
        Cart::create($request->except('_token'));
        if ($request->type == 'cart') {
            return redirect()->back()->with('success','Product Added To Cart Successfully');
        }elseif ($request->type == 'wishlist') {
            return redirect()->back()->with('success','Product Added To Wishlist Successfully');
        }
    }
    public function remove_item($id)
    {
        Cart::findOrFail($id)->delete();
        return redirect()->back()->with('success','Product Deleted From Cart Successfully');

    }
}
