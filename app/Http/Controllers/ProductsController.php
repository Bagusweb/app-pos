<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Categories;
use App\Products;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataProducts = Products::orderBy('product_id', 'desc')->get();
        return view('products.index', compact('dataProducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataCategory = Categories::all();
        return view('products.create', compact('dataCategory'));
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
            'product_name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'product_description' => 'required',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Validasi foto
        ]);

        $photoPath = null; //product-photo/smkutama.png

        // Jika ada file yang diunggah
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->
            store('product-photos', 'public'); // Simpan ke folder public/storage
        }
        
        Products::create([
            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'product_description' => $request->product_description,
            'photo' => $photoPath,
        ]);

        return redirect(route('product.index'));
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
        $dataEditproduct = Products::find($id);
        $categories = Categories::all();
        return view('products.edit', compact('dataEditproduct', 'categories'));
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
        $this->validate($request, [
            'product_name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'product_description' => 'required',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Validasi foto
        ]);

        
        $dataUpdateproduct = Products::find($id);
        $photoPath = $dataUpdateproduct->photo;

        // Jika ada file yang diunggah
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($dataUpdateproduct->photo) {
                Storage::disk('public')->delete($dataUpdateproduct->photo);
            }

            $photoPath = $request->file('photo')->
            store('product-photos', 'public'); // Simpan foto baru
        }
        
        $dataUpdateproduct->update([
            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'product_description' => $request->product_description,
            'photo' => $photoPath,
        ]);

        return redirect(route('product.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Products::where('product_id', $id)->delete();
        return redirect(route('product.index'));
    }
}