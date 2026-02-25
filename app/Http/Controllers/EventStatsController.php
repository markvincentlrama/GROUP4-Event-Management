<?php

namespace App\Http\Controllers;


use App\Models\Event; 
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EventStatsController extends Controller
{
    public function index()
    {
        
        return response()->json([
            'total_events'  => Event::count(),
            'total_revenue' => Event::sum('revenue'),
            'by_category'   => Event::select('category', DB::raw('count(*) as count'))
                                ->groupBy('category')
                                ->get()
        ]);
    }
}