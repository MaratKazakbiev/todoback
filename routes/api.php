<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;


Route::group(['middleware'=> 'auth:sanctum'], function(){


    Route::get('/user/get', [UserController::class, 'get_user']);
    Route::post('user/delete', [UserController::class, 'delete_user']);
    Route::post('/user/update', [UserController::class, 'update_user']);

    Route::get('/todos/get', [TodoController::class, 'get_todos']);
    Route::post('/todo/create', [TodoController::class, 'create_todo']);
    Route::post('/todo/update', [TodoController::class, 'update_todo']);
    Route::post('/todo/delete', [TodoController::class, 'delete_todo']);

});


Route::post('/user/create', [UserController::class, 'create_user']);
Route::post('/user/login', [LoginController::class, 'login_user']);


