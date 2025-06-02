<?php

use App\Http\Controllers\AuthController;
use App\Models\Detail_asset;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::get('/debug-assets', function () {
//     return Detail_asset::with('division')->get()->map(function ($item) {
//         return [
//             'code_asset' => $item->code_asset,
//             'division_id' => $item->division_id,
//             'division_name' => optional($item->division)->division_name,
//         ];
//     });
// });
