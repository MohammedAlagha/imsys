<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Alert extends Model
{
    protected $fillable = [
        'pump_id', 'type', 'value', 'status', 'severity',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pump()
    {
        return $this->belongsTo(Pump::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'alerts_users', 'alert_id', 'user_id', 'id', 'id')
            ->withTimestamps();
    }

    public function read()
    {
        $this->users()->syncWithoutDetaching(Auth::user());
    }

    public function scopeRecent(Builder $builder, $limit = 0)
    {
        return $builder->where('status', 'open')->when($limit, function($builder, $limit) {
            return $builder->take($limit);
        })->latest();
    }
}
