<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

abstract class Controller
{
    use ApiResponseTrait;

    public function __construct(protected $service) {}

    public function all()
    {
        return $this->handleSuccessResponse($this->service->getAll());
    }

    public function show(mixed $id)
    {
        return $this->handleSuccessResponse($this->service->getById($id));
    }

    public function store(Request $request)
    {
        $response = $this->service->create($request->validated() ?? $request->all());

        return $this->handleSuccessResponse($response['data'], $response['message'], 201);
    }

    public function update(Request $request, mixed $id)
    {
        $response = $this->service->update($id, $request->validated() ?? $request->all());

        return $this->handleSuccessResponse($response['data'], $response['message']);
    }

    public function delete(mixed $id)
    {
        return $this->handleSuccessResponse(null, $this->service->delete($id));
    }

}
