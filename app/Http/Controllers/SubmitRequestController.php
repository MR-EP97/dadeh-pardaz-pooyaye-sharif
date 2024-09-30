<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpenseResource;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class SubmitRequestController extends Controller
{
    public function create()
    {
        return ExpenseResource::collection(ExpenseCategory::all());
    }
}
