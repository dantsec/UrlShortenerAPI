<?php

namespace App\Http\Controllers\UrlManagement;

use App\Models\Url;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class RedirectController extends Controller
{
    /**
     * Redirect user to original url based on saved hash at database.
     *
     * @param string $hash
     *
     * @return JsonResponse
     */
    public function __invoke(string $hash): JsonResponse
    {
        $longUrl = Url::findByHash($hash)?->long_url;

        if (!isset($longUrl)) {
            return ResponseFormatter::formatResponse(
                'error',
                404,
                'URL Not Found',
            );
        }

        return ResponseFormatter::formatResponse(
            'success',
            302,
            'Redirecting to the long URL',
            ['redirect' => true],
            ['Location' => $longUrl]
        );
    }
}
