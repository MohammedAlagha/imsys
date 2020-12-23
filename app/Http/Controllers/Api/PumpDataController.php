<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\PumpData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Throwable;

class PumpDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PumpData::latest()->limit(28800)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'pump_id' => 'required|int|exists:pumps,id',
            'state' => 'in:1,0',
            'total_start' => 'int|min:0',
            'total_running_time' => 'numeric|min:0',
            'temp_main_bearing' => 'numeric|min:0',
            'temp_stator' => 'numeric',
            'ohm_leak_stator' => 'numeric',
            'leak_junction' => 'numeric',
            'temp_main_bearing_alarm' => 'int',
            'temp_stator_alarm' => 'int',
            'ohm_leak_stator_alarm' => 'int',
            'leak_junction_alarm' => 'int',
            'data_time' => 'date_format:"Y-m-d H:i:s"',
        ]);

        try {
            $data = PumpData::create($request->all());
            //$data->alerts();
        } catch(Throwable $e) {
            return Response::json([
                'code' => 0,
                'message' => $e->getMessage(),
            ]);
        }
        
        return Response::json([
            'code' => 0,
            'message' => __('Data stored.'),
            'data' => $data
        ]);
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
}
