<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/news', [ApiController::class, 'index'])->name('news.index');



Route::get('/', function () {
    return view('welcome');
});
