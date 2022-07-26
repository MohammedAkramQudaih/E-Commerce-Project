<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
        return view('admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $discounts=Discount::all();
        $categories=Category::all();
        return view('admin.products.create', compact('discounts','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required',
            'image'=>'required',
            'quantity'=>'required',
            'description'=>'required',
            'category_id'=>'required'
        ]);

        $ex = $request->file('image')->getClientOriginalExtension();
        $single_name = 'ata'.rand().time().'.'.$ex;
        $request->file('image')->move(public_path('images'),$single_name);

        $alb_name_arr=[];
        foreach($request->file('album') as $alb){
            $ex= $alb->getClientOriginalExtension();
            $alb_name= 'ata'.rand().time().'.'.$ex;
            $alb_name_arr[]=$alb_name;
            $alb->move(public_path('images'),$alb_name);
        }
        $alb_name_arr = implode(',',$alb_name_arr);

        Product::create([
            'user_id'=> Auth::user()->id,
            'category_id'=>$request->category_id,
            'discount_id'=>$request->discount_id,
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
            'peice'=>$request->price,
            'image'=>$single_name,
            'album'=>$alb_name_arr,
            'description'=>$request->description,
            'quantity'=>$request->quantity,
            'serial_number'=>$request->serial_number
        ]);
        return redirect()->route('admin.products.index')->with('msg','Product Created Successfully')->with('type','success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discounts=Discount::findOrFail($id);
        $categories=Category::findOrFail($id);
        $products=Product::findOrFail($id);
        return view('admin.products.edit',compact('discounts','categories','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'name'=>'required',
        //     'price'=>'required',
        //     'image'=>'required',
        //     'quantity'=>'required',
        //     'description'=>'required',
        //     // 'category_id'=>'required'
        // ]);

        // $ex = $request->file('image')->getClientOriginalExtension();
        // $single_name = 'ata'.rand().time().'.'.$ex;
        // $request->file('image')->move(public_path('images'),$single_name);

        // $alb_name_arr=[];
        // foreach($request->file('album') as $alb){
        //     $ex= $alb->getClientOriginalExtension();
        //     $alb_name= 'ata'.rand().time().'.'.$ex;
        //     $alb_name_arr[]=$alb_name;
        //     $alb->move(public_path('images'),$alb_name);
        // }
        // $alb_name_arr = implode(',',$alb_name_arr);

        // Product::findOrfail($id)->update([
        //     'user_id'=> Auth::user()->id,
        //     'category_id'=>$request->category_id,
        //     'discount_id'=>$request->discount_id,
        //     'name'=>$request->name,
        //     'slug'=>Str::slug($request->name),
        //     'peice'=>$request->price,
        //     'image'=>$single_name,
        //     'album'=>$alb_name,
        //     'description'=>$request->description,
        //     'quantity'=>$request->quantity,
        //     'serial_number'=>$request->serial_number
        // ]);
        // return redirect()->route('admin.products.index')->with('msg','Product Updated Successfully')->with('type','prymary');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products.index')->with('msg','Product Deleted Successfully')->with('type','danger');

    }
}
