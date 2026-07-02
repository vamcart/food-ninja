<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/go/{id}', [GoController::class, 'go']);