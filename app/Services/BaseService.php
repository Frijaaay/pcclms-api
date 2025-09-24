<?php

namespace App\Services;

abstract class BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected $repository) {}

    protected function serviceReturn(mixed $data, string $message = "Data retrieved successfully")
    {
        return [
            'message' => $message,
            'data' => $data
        ];
    }

    public function getAll()
    {
        return $this->serviceReturn($this->repository->all());
    }

    public function getById($id)
    {
        return $this->serviceReturn($this->repository->findById($id));
    }

    public function create($data)
    {
        return $this->serviceReturn($this->repository->store($data), "Create success");
    }

    public function update($id, $data)
    {
        return $this->serviceReturn($this->repository->update($id, $data), "Update success");
    }

    public function delete($id)
    {
        return $this->serviceReturn($this->repository->delete($id), "Delete success");
    }
}
