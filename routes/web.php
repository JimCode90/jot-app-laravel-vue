<?php


use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/{any}', [AppController::class, 'index'])->where('any', '.*');
