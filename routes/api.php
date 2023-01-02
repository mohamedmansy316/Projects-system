<?php

use App\Http\Controllers\API\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', 'API\RegisterController@register');
Route::post('login', 'API\RegisterController@login');

Route::prefix('/V1')->group( function (){
    Route::middleware(['auth:api', 'middleware' => 'isAdmin'])->group( function (){
        Route::resource('projects', 'API\ProjectController');
    });

    Route::middleware('auth:api')->group( function (){
        Route::resource('tasks', 'API\TaskController');
    });

    Route::get('all-tasks', 'API\TaskController@allTasks');
    Route::middleware('auth:api')->group( function (){
        Route::post('submitTask/{id}', 'API\TaskController@submitTask');
    });
});
