<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetController;
use App\Http\Controllers\GetTodo;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;




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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=> 'auth:sanctum'], function(){

    Route::get('/get', GetController::class);
    Route::get('/gettodos', GetTodo::class);

    //Маршруты для работы с данными в таблице пользователей
    Route::get('/getuser', [UserController::class, 'GetUser'])->name('get.user');
    Route::post('/updateuser', [UserController::class, 'UpdateUser'])->name('update.user');
    Route::post('/deleteuser', [UserController::class, 'DeleteUser'])->name('delete.user');

    //Маршруты для работы с данными в таблице задач
    Route::get('/gettodos', [TodoController::class, 'GetTodos'])->name('get.todos');
    Route::post('/createtodo', [TodoController::class, 'CreateTodo'])->name('create.todo');
    Route::post('/updatetodo', [TodoController::class, 'UpdateTodo'])->name('update.todo');
    Route::post('/deletetodo', [TodoController::class, 'DeleteTodo'])->name('delete.todo');


});


Route::post('/createuser', [UserController::class, 'CreateUser'])->name('create.user');

