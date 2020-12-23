<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Pump extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label', 'station_id', 'model', 'serial',
    ];
    
    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function data()
    {
        return $this->hasMany(PumpData::class);
    }
    
    public function alerts()
    {
        return $this->hasMany(Alert::class)->latest();
    }

    public function activeAlerts()
    {
        return $this->hasMany(Alert::class)->where('status', 'open')->latest();
    }

    public function scopeData(Builder $builder)
    {
        $data = PumpData::select([
            'pump_id',
            'state',
            'total_start',
            'total_running_time',
            'temp_main_bearing',
            'temp_stator',
            'ohm_leak_stator',
            'leak_junction',
            'data_time'
        ])->whereRaw('created_at = (SELECT MAX(d2.created_at) FROM pump_data as d2 WHERE d2.pump_id = pump_data.pump_id)');

        return $builder->leftJoinSub($data, 'data', function ($join) {
            $join->on('pumps.id', '=', 'data.pump_id');
        });
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validator($data)
    {
        $validator = Validator::make($data, [
            'label' => ['required', 'max:255'],
            'station_id' => ['required', 'exists:stations,id'],
            'model', ['nullable', 'max:255'],
            'serial', ['nullable', 'max:255'],
        ]);
        return $validator;
    }

    public function getStateLabelAttribute()
    {
        return $this->state == 0? 'Off' : 'On';
    }

    public function getRunningTime($period = 24)
    {
        $results = DB::select("
        SELECT
        sum(if(pdata.state=1, 1, 0)) as running_time
        FROM (
            SELECT DISTINCT pump_id, CAST(state as UNSIGNED) as state, DATE_FORMAT(data_time, '%Y-%m-%d %H:%i:00') as data_time
            FROM pump_data
        ) as pdata
        WHERE pdata.pump_id = :id
        AND pdata.data_time BETWEEN :from AND :to
        ", [
            'id' => $this->id,
            'from' => Carbon::now()->subHours($period)->format('Y-m-d H:i:s'),
            'to' =>  Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $miutes = $results[0]->running_time;
        return [
            'hours' => intval($miutes / 60),
            'minutes' => intval($miutes % 60),
        ];
        
    }
}
