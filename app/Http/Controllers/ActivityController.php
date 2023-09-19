<?php

namespace App\Http\Controllers;

use App\Models\Bulan;
use App\Models\Metode;
use Illuminate\Http\Request;
use App\Models\LearningActiviti;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('activity.index', [
            'metodes'   => Metode::all(),
            'bulans'    => Bulan::all()
        ]);
    }

    public function getDataActivity()
    {
        return response()->json([
            'success' => true,
            'data'    => LearningActiviti::with(['metode', 'bulan'])
                ->orderBy('id', 'DESC')->get()
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
            'activity'  => 'required',
            'metode_id' => 'required',
            'bulan_id'  => 'required'
        ],[
            'activity.required'     => 'acitivty Tidak Boleh Kosong !',
            'metode_id.required'    => 'metode Tidak Boleh Kosong !',
            'bulan_id.required'     => 'bulan Tidak Boleh Kosong !',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $activity = LearningActiviti::create([
            'activity'      => $request->activity,
            'metode_id'     => $request->metode_id,
            'bulan_id'      => $request->bulan_id,

        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan !',
            'data'      => $activity
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $activity = LearningActiviti::find($id);
        return response()->json([
            'success'   => true,
            'message'   => 'Edit Data Activity',
            'data'      => $activity
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $activity = LearningActiviti::find($id);
        $validator = Validator::make($request->all(), [
            'activity'  => 'required',
            'metode_id' => 'required',
            'bulan_id'  => 'required'
        ],[
            'activity.required'     => 'acitivty Tidak Boleh Kosong !',
            'metode_id.required'    => 'metode Tidak Boleh Kosong !',
            'bulan_id.required'     => 'bulan Tidak Boleh Kosong !',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $activity->update([
            'activity'      => $request->activity,
            'metode_id'     => $request->metode_id,
            'bulan_id'      => $request->bulan_id,

        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diupdate !',
            'data'      => $activity
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        LearningActiviti::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!'
        ]);
    }
}
