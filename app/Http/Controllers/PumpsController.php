<?php

namespace App\Http\Controllers;

use App\Pump;
use App\PumpData;
use App\Setting;
use App\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class PumpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(?Station $station = null)
    {
        if ($station) {
            return View::make('pumps.index', [
                'pumps' => $station->pumps()->data()->paginate(),
                'station' => $station,
            ]);
        }

        return View::make('pumps.index', [
            'pumps' => Pump::with('station')->data()->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('pumps.create', [
            'pump' => new Pump(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Pump::validator($data)->validate();
        $pump = Pump::create($data);

        return Redirect::route('pumps.index')
            ->with('alert.success', __('Pump :label created.', ['label' => $pump->label]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pump  $pump
     * @return \Illuminate\Http\Response
     */
    public function show(Pump $pump)
    {
        $thresholds = Setting::find('thresholds');
        return View::make('pumps.show', [
            'pump' => $pump,
            'data' => $pump->data()->latest('data_time')->take(1)->first(),
            'time' => $pump->getRunningTime(),
            'thresholds' => $thresholds? $thresholds->value : '',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pump  $pump
     * @return \Illuminate\Http\Response
     */
    public function edit(Pump $pump)
    {
        return View::make('pumps.edit', [
            'pump' => $pump,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pump  $pump
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pump $pump)
    {
        $data = $request->all();
        Pump::validator($data)->validate();
        $pump->update($data);

        return Redirect::route('pumps.index')
            ->with('alert.success', __('Pump :label updated.', ['label' => $pump->label]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pump  $pump
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pump $pump)
    {
        $pump->delete();
        return Redirect::route('pumps.index')
            ->with('alert.success', __('Pump :label deleted.', ['label' => $pump->label]));
    }

    public function chartState(Pump $pump)
    {
        $data = PumpData::where('pump_id', '=', $pump->id)
            ->whereDate('data_time', '>=', Carbon::now()->subDays(7)->format('Y-m-d'))
            ->whereDate('data_time', '<=', Carbon::now()->format('Y-m-d'))
            ->select([
                DB::raw('FROM_UNIXTIME((UNIX_TIMESTAMP(data_time) div (10*60))*(10*60)+(10*60)) as hour'),
                DB::raw('round(avg(temp_main_bearing),3) as state'),
                //DB::raw('data_time as hour'),
                //DB::raw('temp_main_bearing as state'),
            ])
            ->groupBy('hour')
            ->get();

        $response = [];
        foreach($data as $entry) {
            $response['labels'][] = $entry->hour;
            $response['data'][] = $entry->state;
        }

        return Response::json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pump  $pump
     * @return \Illuminate\Http\Response
     */
    public function export(Pump $pump)
    {
        $data = $pump->data()->latest('data_time')
            ->whereDate('data_time', '>=', Carbon::now()->subHours(24))
            ->get();

        $spreadsheet = new Spreadsheet;
        $c = 'A';
        $r = 1;
        foreach($data->first()->attributesToArray() as $header => $value) {
            $spreadsheet->getActiveSheet()->setCellValue("$c$r", Str::of($header)->title()->replace('_', ' '));
            $c++;
        }
        $r = 2;
        foreach($data as $row) {
            $c = 'A';
            foreach($row->attributesToArray() as $value) {
                $spreadsheet->getActiveSheet()->setCellValue("$c$r", $value);
                $c++;
            }
            $r++;
        }
        return Response::streamDownload(function() use ($spreadsheet) {
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        }, "pump-{$pump->label}-data.xlsx", [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
