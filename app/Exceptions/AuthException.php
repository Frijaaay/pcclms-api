<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class AuthException extends Exception
{
    private const ERROR_CODE = 401;

    public function __construct(string $message = "Invalid Credentials", int $code = self::ERROR_CODE, \Throwable $previous = null)
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
        ], $this->getCode());
    }
}
