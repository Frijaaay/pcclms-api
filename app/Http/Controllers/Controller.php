<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;

abstract class Controller
{
    use ApiResponseTrait;

    public function __construct(protected $service) {}

    public function all()
    {
        $response = $this->service->getAll();
        return $this->handleSuccessResponse($response['data'], $response['message']);
    }

    public function show(mixed $id)
    {
        $response = $this->service->getById($id);
        return $this->handleSuccessResponse($response['data'], $response['message']);
    }

}
