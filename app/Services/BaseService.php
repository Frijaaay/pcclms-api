<?php

namespace App\Services;

use App\Contracts\Repositories\BaseRepositoryInterface;
use App\Exceptions\InvalidRequestException;

abstract class BaseService
{
    /**
     * Summary of constructor
     * @template TRepository of BaseRepositoryInterface
     * @var TRepository
     * @param TRepository $repository
     */
    public function __construct(protected readonly BaseRepositoryInterface $repository) {}

    protected function serviceArrayReturn(mixed $data, string $message = "Data retrieved successfully"): Array
    {
        return [
            'message' => $message,
            'data' => $data
        ];
    }

    public function getAll(): Array
    {
        return $this->serviceArrayReturn($this->repository->all());
    }

    public function getById(mixed $id): Array
    {
        return $this->serviceArrayReturn($this->repository->findById($id));
    }

    public function create(array $data): Array
    {
        return $this->serviceArrayReturn($this->repository->store($data), "Create success");
    }

    public function update(mixed $id, array $data): Array
    {
        return $this->serviceArrayReturn($this->repository->update($id, $data), "Update success");
    }

    public function delete(mixed $id): Array
    {
        return $this->serviceArrayReturn($this->repository->delete($id), "Delete success");
    }
}
