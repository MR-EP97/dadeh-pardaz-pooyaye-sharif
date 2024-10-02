<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmitRequest;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\SubmitRequestResource;
use App\Models\ExpenseCategory;
use App\Models\SubmitRequest;
use App\Traits\JsonResponseTraits;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class SubmitRequestController extends Controller
{
    use JsonResponseTraits;

    public function create(): JsonResponse
    {
        return $this->success(
            'Data Expense form',
            array(ExpenseResource::collection(ExpenseCategory::all()))
        );
    }

    public function store(StoreSubmitRequest $request): JsonResponse
    {
        $submitRequest = SubmitRequest::create($request->input());
        return $this->success(
            'Create submit request successfully',
            array(SubmitRequestResource::make($submitRequest)),
            HttpResponse::HTTP_CREATED
        );
    }

    public function download($file): \Symfony\Component\HttpFoundation\BinaryFileResponse|JsonResponse
    {

        if (Storage::disk('local')->exists("submit-request/{$file}")) {
            return response()->download(storage_path("app/private/submit-request/" . $file));
        }

        return $this->error();
    }

}
