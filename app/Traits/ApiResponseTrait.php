<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Returns a standardized JSON success response.
     * @param mixed $data Data that goes into the content body.
     * @param string $message Message included in the response.
     * @param int $code HTTP response code.
     */
    protected function handleSuccessResponse(
        mixed $data = null,
        string $message = 'Operation completed successfully.',
        int $code = 200): JsonResponse
    {
        if (!$data) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
            ], $code);
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Returns a standardized JSON error response.
     * @param string $message error message included in the response
     * @param int $code http response code
     * @param mixed $errors errors
     * @return JsonResponse
     */
    protected function handleErrorResponse(string $message = 'An error occured.', mixed $errors, int $code = 400): JsonResponse
    {
        return response()->json([
            'status' => 'failed',
            'code' => $code,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

    /**
     * Returns a standardized JSON with cookie response
     * @param mixed $data
     * @param mixed $cookie
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function handleWithCookieResponse(
        mixed $data,
        mixed $cookie,
        string $message = 'Operation completed successfully.',
        int $code = 200): JsonResponse
        {
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ], $code)
            ->withCookie(
                cookie(
                    name: $cookie['name'],
                    value: $cookie['value'],
                    minutes: $cookie['expiry'],
                    path: '/api/v1/auth',
                    domain: null,
                    secure: env('SESSION_SECURE_COOKIE', app()->environment('production')),
                    httpOnly: true,
                    raw: false,
                    sameSite: 'strict'
                )
        );
        }
}
