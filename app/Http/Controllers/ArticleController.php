<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller
{

    public function __construct() {
        self::$baseModel = 'App\Article';
        $this->fieldsToFill = [
            'title',
            'slug',
            'description_md',
            'short_description',
            'featured_image_id',
            'related_products',
            'tags',
        ];
        $this->fieldsToShow = [
            'title',
            'slug',
            'description_md',
            'short_description',
            'featured_image_id',
            'related_products',
            'tags',
        ];
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
        $all = parent::getAll();
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => true,
                'allItems' => $all
            ]);
        }
    }

    public function getById($id) {
        $article = Article::findOrFail($id);
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => true,
                'article' => $article
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
        $newItem = parent::store($request);
        $success = $newItem != false;
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => $success,
                'newItem' => $newItem
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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
                'success' => $item != false,
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
}
