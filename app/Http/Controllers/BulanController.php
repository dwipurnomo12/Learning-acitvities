<?php

namespace App\Http\Controllers;

use App\Models\Bulan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BulanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bulan.index');
    }

    public function getDataBulan()
    {
        return response()->json([
            'success' => true,
            'data'    => Bulan::orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bulan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bulan'  => 'required'
        ],[
            'bulan.required' => 'bulan Tidak Boleh Kosong !'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $bulan = Bulan::create([
            'bulan'      => $request->bulan,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan !',
            'data'      => $bulan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bulan = Bulan::find($id);
        return response()->json([
            'success'   => true,
            'message'   => 'Edit Data bulan',
            'data'      => $bulan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $bulan = Bulan::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'bulan'          => 'required',
        ],[
            'bulan.required' => 'Form bulan Tidak Boleh Kosong'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $bulan->update([
            'bulan'  => $request->bulan,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Terupdate',
            'data'      => $bulan
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        bulan::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!'
        ]);
    }
}
