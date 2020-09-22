<?php

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. You're free to add
| as many additional routes to this file as your tool may require.
|
 */

Route::namespace ('\Zuma\PosConfig\Http\Controllers')->group(function () {
    Route::get('/{id}', 'PosConfigController@get');
    Route::post('/{id}', 'PosConfigController@update');
});
