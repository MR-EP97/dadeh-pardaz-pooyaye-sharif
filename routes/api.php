<?php

use App\Http\Controllers\SubmitRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/submit-request-form',[SubmitRequestController::class,'create']);
Route::post('/submit-request-form/store',[SubmitRequestController::class,'store']);
