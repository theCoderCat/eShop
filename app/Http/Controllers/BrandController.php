<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;


class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll() {
        $all = Brand::all();
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => true,
                'brands' => $all,
            ]);
        }
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
        //
        $fieldsToFill = [
            'name',
            'slug',
            'description_md',
            'logo_id',
        ];

        $dataToSave = $request->only($fieldsToFill);
        $brand = new Brand;
        foreach ($fieldsToFill as $key ) {
            $brand->$key = $dataToSave[$key];
        }
        $success = $brand->save();
        $brand = Brand::findOrFail($brand->id);
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => $success,
                'brand' => $brand
            ]);
        }
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
        //
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
        //
        $fieldsToFill = [
            'name',
            'slug',
            'description_md',
            'logo_id',
        ];

        $dataToSave = $request->only($fieldsToFill);
        $brand = Brand::findOrFail($request->id);
        $brand->update($dataToSave);
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => $brand ? true : false,
                'brand' => $brand
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getBySlug($slug) {
        $brand = Brand::where('slug', $slug)->firstOrFail();
        return $brand;
    }
}
