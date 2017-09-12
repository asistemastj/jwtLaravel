<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

#rutas para registrar usuario
Route::post('registrar', 'UserController@register');
#ruta para iniciar sesión
Route::post('login', 'UserController@login');
#ruta para conseguir usuario autenticado
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('usuario', 'UserController@getAuthUser');
});