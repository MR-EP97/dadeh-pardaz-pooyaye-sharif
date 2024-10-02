<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubmitRequestApprovalController;
use App\Http\Controllers\SubmitRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/submit-request-form', [SubmitRequestController::class, 'create']);
Route::post('/submit-request-form/store', [SubmitRequestController::class, 'store']);

Route::get('/dashboard/submit-request/review', [SubmitRequestApprovalController::class, 'review']);
Route::post('/dashboard/submit-request/decision', [SubmitRequestApprovalController::class, 'decision']);

Route::get('/dashboard/submit-request/show-reject-description/{id}', [SubmitRequestApprovalController::class, 'showRejectDescription'])->name('show-reject-description');
Route::post('/dashboard/submit-request/pay-requests', PaymentController::class);

