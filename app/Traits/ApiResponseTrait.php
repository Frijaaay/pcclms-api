<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Summary of handleSuccessResponse
     * @param mixed $data data that goes into the content body
     * @param string $message message included in the response
     * @param int $code http response code
     * @return JsonResponse
     */
    protected function handleSuccessResponse(mixed $data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'content' => $data
        ], $code);
    }

    /**
     * Summary of handleErrorResponse
     * @param string $message error message included in the response
     * @param int $code http response code
     * @param mixed $errors errors
     * @return JsonResponse
     */
    protected function handleErrorResponse(string $message = 'Something went wrong );', int $code = 400): JsonResponse
    {
        return response()->json([
            'error' => [
                'code' => $code,
                'message' => $message,
            ]
        ], $code);
    }
}
