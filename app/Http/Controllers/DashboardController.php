<?php

namespace App\Http\Controllers;

use App\Models\Bulan;
use App\Models\Metode;
use Illuminate\Http\Request;
use App\Models\LearningActiviti;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metodes    = Metode::all();
        $bulans     = Bulan::all();
        $activities = LearningActiviti::all();
    
        $activityByMetodeAndBulan = [];
    
        foreach ($activities as $activity) {
            $activityByMetodeAndBulan[$activity->metode_id][$activity->bulan_id] = $activity->activity;
        }
    
        return view('dashboard', compact('metodes', 'bulans', 'activityByMetodeAndBulan'));
    }

}
