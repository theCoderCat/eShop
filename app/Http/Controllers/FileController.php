<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\File;

class FileController extends Controller
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
        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            //
            $newFile = new File;
            $ext = $request->img->getMimeType();
            $path = $request->img->store('files');
            $newFile->type = $ext;
            $newFile->location = $path;
            $newFile->original_name = $request->img->getClientOriginalName();
            $newFile->ext = $request->img->getClientOriginalExtension();
            $newFile->file_size = $request->img->getClientSize();
            $success = $newFile->save();

            if ($success) {
                $resData = array(
                    "id" => $newFile->id,
                    "original_name" => $newFile->original_name,
                    "url" => route('getFileByIdAndName', ['id' => $newFile->id, "fileName" => $newFile->original_name])
                );
                return response()->json([
                    'success' => true,
                    'file' => $resData
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot save file",
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => "Invalid file",
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $fileName)
    {
        //
        $file = File::where('id', $id)
               ->first();
        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        if ($file) {
            return response()->file($storagePath.$file->location);
        } else {
            abort(404, 'File not found');
        }
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

    public function getAll() {
        $allFiles = File::all();
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => true,
                'files' => $allFiles,
            ]);
        }
    }

    public function getByType($type) {
        $allFiles = File::where('type', 'like', "%".$type."%")
               ->orderBy('created_at', 'desc')
               ->get();
        if (config('res.onlyJson') || config('res.isJson')) {
            return response()->json([
                'success' => true,
                'files' => $allFiles,
            ]);
        }
    }
}
