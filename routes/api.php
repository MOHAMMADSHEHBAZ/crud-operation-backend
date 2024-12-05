<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/getUsers', [UserController::class, 'getUsers']);
Route::get('/getUsersCount', [UserController::class, 'getUsersCount']);
Route::post('/CreateUser', [UserController::class, 'CreateUser']);
Route::get('/getUsersDetails/{id}', [UserController::class, 'getUsersDetails']);
