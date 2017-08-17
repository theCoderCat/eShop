<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;


class BrandController extends Controller
{
    
    public function __construct() {
        self::$baseModel = 'App\Brand';
        $this->fieldsToFill = [
            'name',
            'slug',
            'description_md',
            'logo_id',
        ];
        $this->fieldsToShow = [
            'id',
            'name',
            'slug',
            'logo_id',
            'description_md',
        ];
        $this->relationToShow = ['logo'];
    }

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
        $all = parent::getAll();
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => true,
                'allItems' => $all,
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
        $newItem = parent::store($request);
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => true,
                'newItem' => $newItem
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
        $item = parent::update($request, $id);
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => $item ? true : false,
                'updatedItem' => $item
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
