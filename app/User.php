<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function(User $user) {
            $user->password = Hash::make($user->password);
        });
        /*static::updating(function(User $user) {
            $dirty = $user->getDirty();
            if (isset($dirty['password'])) {
                $user->password = Hash::make($user->password);
            }
        });*/
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validator($data, User $user = null)
    {
        if ($user !== null) {
            $validator = Validator::make($data, [
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255', "unique:users,email,{$user->id}"],
            ]);
        } else {
            $validator = Validator::make($data, [
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'max:8', 'confirmed'],
            ]);
        }
        
        return $validator;
    }
}
