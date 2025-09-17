<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InvalidRequestException extends Exception
{
    public const ERROR_CODE = 200;
    public function __construct(string $message = "Invalid Request", int $code = self::ERROR_CODE, \Throwable $previous = null)
    {
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'error' => [
                'code' => $this->getCode(),
                'message' => $this->getMessage()
            ]
        ], self::ERROR_CODE);
    }
}
