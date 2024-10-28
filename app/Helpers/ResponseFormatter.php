<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseFormatter
{
    /**
     * Formats the JSON response for the API.
     *
     * @param string $status
     * @param int $code
     * @param ?string $message
     * @param array $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function formatResponse(
        string $status,
        int $code,
        string $message = null,
        array $data = [],
        array $headers = []
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ], $code, $headers);
    }
}
