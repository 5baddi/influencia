<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::withCount('users')->with('users')->get();
        return $brands;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();


        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'name' => 'required|string'
        ]);

        $uploadPath = public_path('upload');

        $imageName =  Str::slug(request('name') . '_') . time() . '.' . $request->file('image')->getClientOriginalExtension();
        $path = $request->file('image')->storeAs('uploads', $imageName, 'public');

        $brand = Brand::create([
            "name"  => request('name'),
            "logo"  => '/storage/' . $path,
            "uuid"  => Str::uuid()
        ]);
        $user->update([
            'selected_brand_id' => $brand->id
        ]);

        $brand->users()->attach($user);
        return response($brand->load('users'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brands  $brands
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brands)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brands  $brands
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brands)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brands  $brands
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brands)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brands  $brands
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brands)
    {
        //
    }
}
