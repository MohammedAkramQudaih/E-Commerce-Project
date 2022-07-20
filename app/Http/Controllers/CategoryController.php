<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();//celect * from Categories
        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $request->validate([
            'name'=>'required|unique:categories,name'
        ]);

        //create
        Category::create([
            'name'=> $request->name,
            'slug'=> Str::slug($request->name)
        ]);

        // Return with massage
        return redirect()->route('admin.categories.index')->with('msg','Category Created Successfully')->with('type','success');


        // Category::create($request->all());
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
        $category=Category::findOrFail($id);
        return view('admin.categories.edit',compact('category'));
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
         //validation
         $request->validate([
            'name'=>'required|unique:categories,name,'.$id
        ]);

        //update
        Category::findOrFail($id)->update([
            'name'=> $request->name,
            'slug'=> Str::slug($request->name)
        ]);

        // Return with massage
        return redirect()->route('admin.categories.index')->with('msg','Category Ubdated Successfully')->with('type','primary');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        // Return with massage
        return redirect()->route('admin.categories.index')->with('msg','Category Deleted Successfully')->with('type','danger');
        
    }
}
