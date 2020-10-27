<?php

namespace App\Http\Controllers;

use App\User;
use App\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Symfony\Component\HttpFoundation\Response;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('list_brand') && Gate::denies('viewAny', Auth::user()), Response::HTTP_FORBIDDEN, "403 Forbidden");

        $brands = Brand::withCount(['users', 'campaigns'])
                        ->with(['users', 'campaigns']);

        if(!Auth::user()->is_superadmin){
            $brands = $brands->whereHas('users', function($query){
                $query->where('user_id', Auth::id());
            });
        }

        return response()->success("Brands fetched successfully.", 
            $brands->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreBrandRequest $request)
    {
        // Set data
        $data = $request->validated();

        // Generate file name
        if($request->file('logo')){
            $fileName = Str::slug($data['name']) . '_' . time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $path = $request->file('logo')->storeAs('uploads', $fileName, 'public');
            
            if($path)
                $data['logo'] = "/storage/". $path;
        }   

        // Get current user
        $user = User::find(Auth::id());

        // Store the brand
        $brand = Brand::create($data);
        $brand->users()->attach($user);
        $user->update([
            'selected_brand_id' => $brand->id
        ]);

        return response()->success("Brand created successfully.", $brand->load(['users', 'campaigns'])->toArray(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        abort_if(Gate::denies('show_brand') && Gate::denies('view', $brand), Response::HTTP_FORBIDDEN, "403 Forbidden");

        return response()->success("Brand fetched successfully.", $brand->load(['users', 'campaigns'])->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Brand $brand, UpdateBrandRequest $request)
    {
        abort_if(Gate::denies('edit_brand') && Gate::denies('update', $brand), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Set data
        $data = [];
        if($request->input('name'))
            $data['name'] = $request->input('name');

        // Generate file name
        if($request->file('logo')){
            $fileName = Str::slug($data['name']) . '_' . time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $path = $request->file('logo')->storeAs('uploads', $fileName, 'public');
            
            if($path)
                $data['logo'] = "/storage/". $path;
        }   

        // Update the brand
        $brand->update($data);

        return response()->success("Brands fetched successfully.", $brand->load('users')->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function delete(Brand $brand)
    {
        abort_if(Gate::denies('delete_brand') && Gate::denies('delete', $brand), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Delete brand
        $brand->delete();

        return response()->json([
            'success'   =>  true,
            'message'   =>  'Brand deleted successfully.'
        ]);
    }
}
