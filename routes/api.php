<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/scan/{kode_qr}', [ArsipController::class, 'cariArsip']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
