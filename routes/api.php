<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\TaskController;
use App\Http\Controllers\Api\V1\CommentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1','middleware' => 'api'], function () {
    
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('logout-all', [AuthController::class, 'logoutFromAllDevices']);
        });
    });

      Route::group(['middleware' => 'auth:sanctum'], function () {
            # Tasks
            Route::apiResource('/tasks', TaskController::class);
           
            # Comments 
            Route::get('/tasks/{task}/comments', [CommentController::class, 'indexByTask']);
            Route::post('/comments', [CommentController::class, 'store']);
            Route::put('/comments/{comment}', [CommentController::class, 'update']);
            Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
      });


});
