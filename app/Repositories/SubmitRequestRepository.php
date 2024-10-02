<?php

namespace App\Repositories;

use App\Interfaces\SubmitRequestRepositoryInterface;
use App\Models\SubmitRequest;

class SubmitRequestRepository implements SubmitRequestRepositoryInterface
{

    public function all(): \Illuminate\Database\Eloquent\Builder
    {
        return SubmitRequest::query();
    }

    public function create(array $data): SubmitRequest
    {
        return SubmitRequest::query()->create($data);
    }

    public function update(array $data, $id): SubmitRequest
    {
        $submitRequest = SubmitRequest::query()->findOrFail($id);
        $submitRequest->update($data);
        return $submitRequest;
    }

    public function delete($id): void
    {
        $submitRequest = SubmitRequest::findOrFail($id);
        $submitRequest->delete();
    }

    public function find($id): SubmitRequest
    {
        return SubmitRequest::findOrFail($id);
    }
}
