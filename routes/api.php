<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum', 'signed'])->group(function () {
    Route::get('/email/verify/{id}/{hash}', function (Request $request) {
        $request->user()->markEmailAsVerified();
        return response()->json(['message' => 'Email verified']);
    })->name('verification.verify');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('enable-two-factor', [AuthController::class, 'enableTwoFactor']);
    Route::post('disable-two-factor', [AuthController::class, 'disableTwoFactor']);
    Route::post('verify-two-factor', [AuthController::class, 'verifyTwoFactor']);
    Route::post('send-two-factor-code', [AuthController::class, 'sendTwoFactorCode']);
});
