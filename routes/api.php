<?php

use App\Http\Controllers\SubmitRequestApprovalController;
use App\Http\Controllers\SubmitRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/submit-request-form',[SubmitRequestController::class,'create']);
Route::post('/submit-request-form/store',[SubmitRequestController::class,'store']);

Route::get('/dashboard/submit-request/review',[SubmitRequestApprovalController::class,'review']);
Route::post('/dashboard/submit-request/decision',[SubmitRequestApprovalController::class,'decision']);
Route::post('/dashboard/submit-request/reject-description',[SubmitRequestApprovalController::class,'rejectDescription']);

