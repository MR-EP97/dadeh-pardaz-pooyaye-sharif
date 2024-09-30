<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmitRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\ExpenseCategory;
use App\Models\SubmitRequest;
use Illuminate\Http\Request;

class SubmitRequestController extends Controller
{
    public function create()
    {
        return ExpenseResource::collection(ExpenseCategory::all());
    }

    public function store(StoreSubmitRequest $request)
    {
       return SubmitRequest::create($request->input());
    }
}
