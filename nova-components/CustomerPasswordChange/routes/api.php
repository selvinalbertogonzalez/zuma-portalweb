<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::get('/endpoint', function (Request $request) {
//     //
// });
Route::post('/', function (Request $request) {
    $user = \App\ZumaUser::find($request->id);
    $user->Contrasena = $request->password;
    $user->save();

    return response()->json(['message' => 'updated_successfully']);
});