<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('users', 'UserController@index');
Route::resource('user', 'UserController')->only(['store', 'show', 'update', 'destroy']);

Route::get('delegations', 'DelegationController@index');
Route::post('delegations', 'DelegationController@store');
Route::resource('delegation', 'DelegationController')->only(['store', 'update']);
