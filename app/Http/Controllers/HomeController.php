<?php

namespace App\Http\Controllers;

use App\Alert;
use App\Pump;
use App\Services\Weather;
use App\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $weather = Weather::get('Gaza,ps');
        $alerts = Alert::with('pump')->recent(5)->get();
        return view('home', [
            'weather' => $weather,
            'alerts' => $alerts,
            'pumps' => Pump::count(),
            'stations' => Station::count(),
            'active_pumps' => Pump::whereHas('data', function($query) {
                $query->whereDate('data_time', '>=', Carbon::now()->subDay());
            })->count(),
            'active_stations' => Station::whereHas('pumps', function($query) {
                $query->whereExists(function($query) {
                    $query->select(DB::raw(1))
                    ->from('pumps')
                    ->whereColumn('pumps.station_id', 'stations.id')
                    ->whereExists(function($query) {
                            $query->select(DB::raw(1))
                            ->from('pump_data')
                            ->whereColumn('pump_data.pump_id', 'pumps.id');
                    });
                });
            })->count(),
        ]);
    }
}
