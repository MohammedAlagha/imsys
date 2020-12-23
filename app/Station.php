<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Station extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'location',
    ];
    
    public function pumps()
    {
        return $this->hasMany(Pump::class);
    }

    public function kits()
    {
        return $this->hasManyThrough(Kit::class, Pump::class);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validator($data)
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'max:255'],
            'location' => ['required', 'max:255'],
        ]);
        return $validator;
    }
}
