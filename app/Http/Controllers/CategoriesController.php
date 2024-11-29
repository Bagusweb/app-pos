<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories; //untuk memanggil model categories

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCategory = Categories::orderBy('category_id', 'desc')->get();
        return view('categories.index', compact('dataCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'category_name' => 'required|unique:tbl_categories',
            'description'   => 'required',
        ]);

        Categories::create([
            'category_name' => $request->category_name,
            'description' => $request->description
        ]);

        return redirect(route('category.index'));
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
        $dataEditcategory = Categories::find($id);
        return view('categories.edit',compact('dataEditcategory'));
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
        $this->validate($request,[
            'category_name' => 'required|unique:tbl_categories,category_name,'.$id.',category_id',
            'description' => 'required'
        ]);

        $ubahCategory = Categories::findOrFail($id);
        $ubahCategory->update([
           'category_name' => $request->category_name,
           'description'    => $request->description
        ]);

        return redirect(route('category.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Categories::where('category_id', $id)->delete();
        return redirect(route('category.index'));
    }
}