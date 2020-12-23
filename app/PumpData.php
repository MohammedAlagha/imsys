<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PumpData extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pump_id',
        'state',
        'total_start',
        'total_running_time',
        'temp_main_bearing',
        'temp_stator',
        'ohm_leak_stator',
        'leak_junction',
        'temp_main_bearing_alarm',
        'temp_stator_alarm',
        'ohm_leak_stator_alarm',
        'leak_junction_alarm',
        'data_time',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'data_time' => 'datetime',
    ];

    protected $alerts = [
        'state',
        'temp_main_bearing_alarm',
        'temp_stator_alarm',
        'ohm_leak_stator_alarm',
        'leak_junction_alarm',
    ];

    protected static function booted()
    {
        static::created(function(PumpData $data) {
            $data->alerts();
        });
    }

    public function getDataTimeAttribute($value)
    {
        if ($value) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $value);
        }
    }

    public function pump()
    {
        return $this->belongsTo(Pump::class);
    }

    public function alerts()
    {
        foreach ($this->alerts as $alert) {
            if ($alert == 'state') {
                $this->checkLastState($this->$alert);
                continue;
            }
            if ($this->$alert) {
                $this->registerAlert($alert);
            } else {
                $this->closeAlertIfExists($alert);
            }
        }
    }

    public function registerAlert($alert)
    {
        $column = str_replace('_alarm', '', $alert);
        Alert::firstOrCreate([
            'pump_id' => $this->pump_id,
            'severity' => 'danger',
            'type' => $column,
            'value' => $this->getAttribute($column),
            'status' => 'open',
        ], []);
    }

    public function closeAlertIfExists($alert)
    {
        $entry = Alert::where([
            'pump_id' => $this->pump_id,
            'type' => str_replace('_alarm', '', $alert),
            'status' => 'open',
        ])->latest()->first();

        if ($entry) {
            $entry->update([
                'status' => 'closed'
            ]);
        }
    }

    public function checkLastState($state)
    {
        $data = PumpData::where('pump_id', $this->pump_id)
            ->where('id', '<>', $this->id)
            ->lateset('data_time')
            ->take(1)
            ->first();
        
        if ($data && intval($data->state) !== intval($state)) {
            Alert::create([
                'pump_id' => $this->pump_id,
                'severity' => 'info',
                'type' => 'state',
                'value' => $state,
                'status' => 'open',
            ]);
        }
    }

    public function getStateLabelAttribute()
    {
        return $this->state == 0? 'Off' : 'On';
    }

}
