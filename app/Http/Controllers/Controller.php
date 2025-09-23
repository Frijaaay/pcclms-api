<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Return JSON Responses
     * @param array $response The response array containing message and data.
     * @param int $status The HTTP status code for the response.
     */
    protected function returnJsonResponse(array $response, int $status = 200): JsonResponse
    {
        return response()->json([
            'message' => $response['message'],
            'content' => $response['data']
        ], $status);
    }
}
