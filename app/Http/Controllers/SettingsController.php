<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class SettingsController extends Controller
{
    protected $settings = [
        'thresholds'
    ];

    public function index()
    {
        return View::make('settings', [
            'settings' => Setting::pluck('value', 'name')->toArray(),
        ]);
    }

    public function store(Request $request)
    {
        foreach ($request->only($this->settings) as $name => $value) {
            Setting::updateOrCreate([
                'name' => $name,
            ], [
                'value' => $value,
            ]);
        }

        return Redirect::route('settings')->with('alert.success', __('Settings saved!'));
    }
}
