<?php

namespace App\Http\Controllers;

use App\Pump;
use App\PumpData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ChartsController extends Controller
{
    public function tempMainBearing(Pump $pump)
    {
        $request = request();
        $period = $request->query('period', 'week');
        $resample = (int) $request->query('resample', 10);
        $resample *= 60;
        switch ($period) {
            case 'custom':
                $days = $request->query('range', 1);
            case '1d':
                $days = 1;
            break;
            case '1m':
                $days = 30;
            break;
            case '1w':
            default:
                $days = 7;
        }
        $data = PumpData::where('pump_id', '=', $pump->id)
            ->whereDate('data_time', '>=', Carbon::now()->subDays($days)->format('Y-m-d'))
            ->whereDate('data_time', '<=', Carbon::now()->format('Y-m-d'))
            ->select([
                DB::raw("FROM_UNIXTIME((UNIX_TIMESTAMP(data_time) div $resample) * $resample + $resample) as label"),
                DB::raw('round(avg(temp_main_bearing), 3) as data'),
            ])
            ->groupBy('label')
            ->get();

        $response = [];
        foreach($data as $entry) {
            $response['labels'][] = $entry->label;
            $response['data'][] = $entry->data;
        }

        return Response::json($response);
    }

    public function state(Pump $pump)
    {
        $request = request();
        $period = $request->query('period', 'day');
        $resample = (int) $request->query('resample', 60);
        $resample *= 60;
        switch ($period) {
            case 'custom':
                $days = $request->query('range', 1);
                $from = Carbon::now()->subDays($days);
            case 'day':
                $days = 1;
                $from = Carbon::now()->subDays($days);
            break;
            case '24-hours':
                $from = Carbon::now()->subHours(24);
            break;
            case 'week':
            default:
                $days = 7;
                $from = Carbon::now()->subDays($days);
        }

        /*return DB::select("SELECT
         DATE_FORMAT(data_time, '%Y-%m-%d %H:%i:00') as datatime,
        sum(IF(pump_data.state=1, 1, 0)) as state
        FROM pump_data
        WHERE pump_id = :id
        AND date(data_time) = :date
        GROUP BY datatime
        ", [
            'id' => $pump->id,
            'date' => (new Carbon())->setDate(2020, 12, 1)->format('Y-m-d'),
        ]);*/

        $data = DB::select("
        SELECT
        FROM_UNIXTIME((UNIX_TIMESTAMP(pdata.data_time) div $resample) * $resample + $resample) as label,
        sum(if(pdata.state=1, 1, 0)) as data
        FROM (
            SELECT DISTINCT pump_id, CAST(state as UNSIGNED) as state, DATE_FORMAT(data_time, '%Y-%m-%d %H:%i:00') as data_time
            FROM pump_data
        ) as pdata
        WHERE pdata.pump_id = :id
        AND pdata.data_time >= :from
        AND pdata.data_time <= :to
        GROUP BY label
        ", [
            'id' => $pump->id,
            'from' => $from->format('Y-m-d'),
            'to' => Carbon::now()->format('Y-m-d'),
        ]);
        
        /*$data = PumpData::where('pump_id', '=', $pump->id)
            ->whereDate('data_time', '>=', $from->format('Y-m-d'))
            ->whereDate('data_time', '<=', Carbon::now()->format('Y-m-d'))
            ->select([
                DB::raw("FROM_UNIXTIME((UNIX_TIMESTAMP(data_time) div $resample) * $resample + $resample) as label"),
                DB::raw('sum(state) as data'),
            ])
            ->groupBy('label')
            ->get();*/

        $response = [];
        $div = ($resample/60 == 1440)? 60 : 1;
        foreach($data as $entry) {
            $response['labels'][] = $entry->label;
            $response['data'][] = $entry->data / $div;
        }

        return Response::json($response);
    }
}
