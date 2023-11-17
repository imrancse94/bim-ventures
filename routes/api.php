<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth',
], function ($router) {
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh-token', [AuthController::class,'refresh']);
    Route::get('auth-info', [AuthController::class,'authInfo']);

    Route::middleware('auth:api')->group(function(){
        
        // transaction
        Route::get('transactions', [TransactionController::class,'getTransactions']);
        Route::post('transaction-create', [TransactionController::class,'create']);
        Route::post('generate-report', [TransactionController::class,'generateReport']);
        
        // Payment
        Route::post('record-payment', [PaymentController::class,'recordPayment']);
        
    });
    
});
