<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubmitRequestApprovalController;
use App\Http\Controllers\SubmitRequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('submit-request-form')->group(function () {
    Route::get('/', [SubmitRequestController::class, 'create']);
    Route::post('/store', [SubmitRequestController::class, 'store']);
});

//download submit request attachments file


Route::prefix('dashboard')->group(function () {
    Route::prefix('/submit-request')->group(function () {
        Route::get('/review', [SubmitRequestApprovalController::class, 'review']);
        Route::put('/decision', [SubmitRequestApprovalController::class, 'decision']);
        Route::get('/show-reject-description/{id}', [SubmitRequestApprovalController::class, 'showRejectDescription'])->name('show-reject-description');
        Route::post('/pay-requests', PaymentController::class);
        Route::get('/get-file/{file}', [SubmitRequestController::class, 'download']);
    });
});
