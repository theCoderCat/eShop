<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected static $baseModel = '';
    protected $fieldsToFill = [];
    protected $fieldsToShow = [];
    protected $relationToShow = [];
    protected $dataToSave = [];

    public function getAll() {
        $baseModel = self::$baseModel;
        if (!empty($this->fieldsToShow) || !empty($this->relationToShow)) {
             $all = $baseModel::select($this->fieldsToShow)->with($this->relationToShow)->get(); 
        }
        else $all = $baseModel::all();
        return $all;
    }

    public function store(Request $request)
    {
        //
        $baseModel = self::$baseModel;
        $dataToSave = $request->only($this->fieldsToFill);
        $dataToSave = array_merge($dataToSave, $this->dataToSave);

        $item = new $baseModel;
        foreach ($this->fieldsToFill as $key ) {
            $item->$key = $dataToSave[$key];
        }
        $success = $item->save();
        return $success ? $newItem = $baseModel::findOrFail($item->id) : $success;
    }

    public function update(Request $request, $id)
    {
        //
        $baseModel = self::$baseModel;
        $dataToSave = $request->only($this->fieldsToFill);
        $item = $baseModel::findOrFail($request->id);
        $success = $item->update($dataToSave);
        if ($success) {
            $item = $baseModel::select($this->fieldsToShow)->where('id', $request->id)->with($this->relationToShow)->first();
            return $item;
        }

        return $success;
    }
}
