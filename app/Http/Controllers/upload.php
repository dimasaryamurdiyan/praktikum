<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model_upload;

class upload extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = model_upload::all();
        return view('file',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('file_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new model_upload();
        $data->nama = $request->input('nama');
        $file = $request-> file('file');
        $ext=$file->getClientOriginalExtension();
        $newName = rand(100000,1001238912).".".$ext;
        $file->move('uploads/file',$newName);
        $data->file = $newName;
        $data->save();
        return redirect()->route('upload.index')->with('alert-success','Berhasil Menambahkan Data!');
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
        $data = model_upload::findOrFail($id);
        return view('file_edit',compact('data'));
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
        $data = model_upload::findOrFail($id);
        $data->nama = $request->input('nama');
        if(empty($request->file('file'))){
            $data->file = $data->file;
        }else{
            unlink('uploads/file/'.$data->file);
            $file = $request->file('file');
            $ext=$file->getClientOriginalExtension();
            $newName = rand(100000,1001238912).".".$ext;
            $file->move('uploads/file',$newName);
            $data->file = $newName;
        }
        $data->save;
        return redirect()->route('upload.index')->with('alert-success','Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = model_upload::findOrFail($id);
        if($data->delete()){
            unlink('uploads/file/'.$data->file);
        }
        return redirect()->route('upload.index')->with('alert-success','Data berhasi dihapus!');
    }
}
