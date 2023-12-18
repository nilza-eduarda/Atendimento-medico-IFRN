<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\VerificarTokenSUAP;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('usuarios', [UserController::class, 'index']);

Route::post('usuarios', [UserController::class, 'store']);

Route::get('usuarios/{cpf}', [UserController::class, 'show'])->middleware(VerificarTokenSUAP::class);

Route::put('usuarios/{cpf}', [UserController::class, 'update'])->middleware(VerificarTokenSUAP::class);

Route::delete('usuarios/{cpf}', [UserController::class, 'destroy'])->middleware(VerificarTokenSUAP::class);
