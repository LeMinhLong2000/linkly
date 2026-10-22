<?php

use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/{code}', [RedirectController::class, 'show'])
    ->where('code', '[A-Za-z0-9]{8}');