<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class EmailUnverifiedException extends Exception
{
    public const ERROR_CODE = 403;

    public function __construct(string $message = "Please verify your email address before logging in.", int $code = self::ERROR_CODE, \Throwable $previous = null)
    {
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'error' => [
                'code' => self::ERROR_CODE,
                'message' => $this->getMessage()
            ]
        ], self::ERROR_CODE);
    }
}
