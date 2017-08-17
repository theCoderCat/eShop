<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    public function __construct() {
        self::$baseModel = 'App\Tag';
        $this->fieldsToFill = [
            'name',
            'sanitized',
            'description',
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
        $success = !empty($all);
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => $success,
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
        $this->dataToSave['sanitized'] = $request->name;
        $newItem = parent::store($request);
        $success = $newItem != false;
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
                'success' => $success,
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
