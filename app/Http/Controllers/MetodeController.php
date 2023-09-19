<?php

namespace App\Http\Controllers;

use App\Models\Metode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MetodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('metode.index');
    }

    
    public function getDataMetode()
    {
        return response()->json([
            'success' => true,
            'data'    => Metode::orderBy('id', 'DESC')->get()
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('metode.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'metode'  => 'required'
        ],[
            'metode.required' => 'Metode Tidak Boleh Kosong !'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $metode = Metode::create([
            'metode'      => $request->metode,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan !',
            'data'      => $metode
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $metode = Metode::find($id);
        return response()->json([
            'success'   => true,
            'message'   => 'Edit Data Metode',
            'data'      => $metode
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $metode = Metode::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'metode'          => 'required',
        ],[
            'metode.required' => 'Form metode Tidak Boleh Kosong'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $metode->update([
            'metode'  => $request->metode,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Terupdate',
            'data'      => $metode
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Metode::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!'
        ]);
    }
}
