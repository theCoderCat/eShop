<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Parsedown;

class ProductController extends Controller
{
    protected $fieldToFill = [
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

    protected $fieldToShow = [
        'brand',
        'description_html',
        'product_images',
        'featured_image',
        'name',
        'slug',
        'tags',
        'price',
        'in_stock',
        'category',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getAll(Request $request) {
        //
        $allProducts = Product::with('brand')->get();
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => true,
                'products' => $allProducts,
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
        $res = Product::where('slug', $slug)->firstOrFail();
        $product = (object)[];
        foreach ($this->fieldToShow as $key) {
            $product->$key = $res->$key;
        }
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
        $newProduct = new Product;
        $dataToSave = $request->except('isJSON');
        foreach ($this->fieldToFill as $key) {
            if (isset($dataToSave[$key])) {
                $product->$key = $dataToSave[$key];
            }
        }
        $Parsedown = new Parsedown;
        $newProduct->description_html = $Parsedown->text($newProduct->description_md);
        $success = $newProduct->save();
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => $success,
                'product' => $newProduct,
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
    public function update(Request $request)
    {
        //
        $id = $request->id;
        $product = Product::findorfail($id);
        $dataToSave = $request->except(['isJSON', 'id']);
        
        foreach ($this->fieldToFill as $key) {
            if (isset($dataToSave[$key])) {
                $product->$key = $dataToSave[$key];
            }
        }
        $Parsedown = new Parsedown;
        $product->description_html = $Parsedown->text($product->description_md);
        $success = $product->save();
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => $success,
                'product' => $product,
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