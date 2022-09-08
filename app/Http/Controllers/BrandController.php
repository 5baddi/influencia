<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\DataTable\BrandDTResource;
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
        // Check abilities
        abort_if(Gate::denies('list_brand') && Gate::denies('viewAny', Auth::user()), Response::HTTP_FORBIDDEN, "403 Forbidden");

        if(!Auth::user()->is_superadmin){
            // Get only user brands
            $brands = Brand::with('users')
                            ->withCount(['users', 'campaigns'])
                            ->whereHas('users', function($query){
                                $query->where('user_id', Auth::id());
                            })
                            ->get();
        }else{
            // Get all brands because it's a superadmin
            $brands = Brand::with('users')
                            ->withCount(['users', 'campaigns'])
                            ->get();
        }

        return response()->success(
            "Brands fetched successfully.",
            BrandDTResource::collection($brands)
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
            $path = $request->file('logo')->storeAs('brands', $fileName, 'local');

            if($path)
                $data['logo'] = $path;
        }

        // Get current user
        $user = Auth::user();

        // Store the brand
        $brand = Brand::create($data);
        $brand->users()->attach($user);

        // Set brand as selected if no already brand selected
        if(is_null($user->selected_brand_id))
            $user->update(['selected_brand_id' => $brand->id]);

        return response()->success("Brand created successfully.", Brand::with(['users', 'campaigns'])->find($brand->id), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        // Check abilities
        abort_if(Gate::denies('show_brand') && Gate::denies('view', $brand), Response::HTTP_FORBIDDEN, "403 Forbidden");

        return response()->success(
            "Brand fetched successfully.", 
            Brand::findOrFail($brand->id)
        );
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
        $data = $request->validated();

        // Generate file name
        if($request->file('logo')){
            $fileName = Str::slug($data['name']) . '_' . time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $path = $request->file('logo')->storeAs('uploads', $fileName, 'public');

            if($path)
                $data['logo'] = $path;
        }

        // Update the brand
        $brand->update($data);

        return response()->success("Brands fetched successfully.", Brand::with(['users', 'campaigns'])->find($brand->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function delete(Brand $brand)
    {
        abort_if(Gate::denies('delete', $brand), Response::HTTP_FORBIDDEN, "403 Forbidden");

        // Delete brand
        $brand->delete();

        return response()->success("Brand deleted successfully.", [], 204);
    }
}
