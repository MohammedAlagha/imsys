<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'register' => false,
]);

Route::middleware('auth')->group(function() {    
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::post('/settings', 'SettingsController@store');

    Route::get('stations/{station}/pumps', 'PumpsController@index')->name('stations.pumps');
    Route::resource('stations', 'StationsController');
    
    Route::get('pumps/{pump}/charts/state', 'ChartsController@state')->name('pumps.chart.state');
    Route::get('pumps/{pump}/charts/temp-main-bearing', 'ChartsController@tempMainBearing')->name('pumps.chart.tempMainBearing');
    Route::get('pumps/{pump}/data/export', 'PumpsController@export')->name('pumps.data.export');
    Route::resource('pumps', 'PumpsController');
    
    Route::resource('users', 'UsersController');

    Route::get('password/{user?}', 'ChangePasswordController@form')->name('users.password');
    Route::put('password/{user?}', 'ChangePasswordController@update');

    Route::get('notifications', 'NotificationsController@index')->name('notifications');
    Route::get('notifications/{id}', 'NotificationsController@read')->name('notifications.read');


    // Temp for development
    Route::get('artisan/{command}', function($command) {
        $allowed = [
            'migrate',
            'storage:link',
            'route:list',
        ];
        if (!in_array($command, $allowed)) {
            return 'Command not allowed!';
        }
        return Artisan::call($command);
    });
    Route::get('migrations/list', function() {
        return DB::table('migrations')->get();
    });
});