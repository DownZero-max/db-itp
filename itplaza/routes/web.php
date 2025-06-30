<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', [OrderController::class, 'index']);

/*Route::get('/', function () {
    return 'Hi! Laravel is ready!';
});*/
