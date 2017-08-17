<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Parsedown;

class ProductController extends Controller
{
    public function __construct() {
        self::$baseModel = 'App\Product';
        $this->fieldsToFill = [
            'brand_id',
            'category_id',
            'description_md',
            'featured_image_id',
            'images',
            'name',
            'slug',
            'tags',
            'price',
            'in_stock'
        ];

        $this->fieldsToShow = [
            'id',
            'brand_id',
            'description_html',
            'images',
            'featured_image_id',
            'name',
            'slug',
            'tags',
            'price',
            'in_stock',
            'category_id',
        ];
        $this->relationToShow = ['featured_image'];
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

    public function getAll() {
        //
        $allProducts = parent::getAll();
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => true,
                'allItems' => $allProducts,
            ]);
        }
    }

    public function getById($id, Request $request) {
        $res = Product::findOrFail($id);
        $product = (object) [
            "name" => $res->name,
            "product_images" => $res->product_images,
            "featured_image" => $res->featured_image,
            "desc" => $res->description_html,
        ];
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => 'success',
                'product' => $res,
            ]);
        }
        return response()->view('store.product-detail', ['product' => $product]);
    }

    public function getBySlug($slug, Request $request) {
        $product = Product::select($this->fieldsToShow)->where('slug', $slug)->with($this->relationToShow)->firstOrFail();
//        $product = (object)[];
//        foreach ($this->fieldsToShow as $key) {
//            $product->$key = $res->$key;
//        }
        // dd($product);
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => true,
                'product' => $product,
            ]);
        }
        return response()->view('store.product-detail', ['product' => $product]);
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
                'success' => $success,
                'newItem' => $newItem,
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
                'success' => true,
                'updatedItem' => $item,
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
}