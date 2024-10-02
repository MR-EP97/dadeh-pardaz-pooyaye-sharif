<?php

namespace App\Services\Repository;

use App\Interfaces\SubmitRequestRepositoryInterface;
use App\Models\SubmitRequest;

class SubmitRequestService
{
    public function __construct(
        protected SubmitRequestRepositoryInterface $srRepository
    )
    {
    }

    public function create(array $data): SubmitRequest
    {
        return $this->srRepository->create($data);
    }

    public function update(array $data, $id): SubmitRequest
    {
        return $this->srRepository->update($data, $id);
    }

    public function delete($id): void
    {
        $this->srRepository->delete($id);
    }

    public function all(int $perPage = 10)
    {
        return $this->srRepository->all()->paginate();
    }

    public function find($id): SubmitRequest
    {
        return $this->srRepository->find($id);
    }
}
