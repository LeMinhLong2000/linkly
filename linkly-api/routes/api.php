<?php

use App\Http\Controllers\Api\LinkController;
use Illuminate\Support\Facades\Route;

// Middleware throttle:10,1 là giới hạn ban đầu 10 request mỗi phút theo cơ chế rate limiter mặc định. 
// Đây chỉ là mức cấu hình cho MVP, không phải ngưỡng phù hợp cho mọi hệ thống
Route::post('/links', [LinkController::class, 'store'])
    ->middleware('throttle:10,1');
