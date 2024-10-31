<?php

namespace App\Http\Controllers\UrlManagement;

use App\Models\Url;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class GetUrlInfoController extends Controller
{
    /**
     * Get saved database informations based on hash.
     *
     * @param string $hash
     *
     * @return JsonResponse
     */
    public function __invoke(string $hash): JsonResponse
    {
        $url = Url::findByHash($hash);

        if (!isset($url)) {
            return ResponseFormatter::formatResponse(
                'error',
                404,
                'URL Not Found',
            );
        }

        $urlData = $url->toArray();
        $metrics = $url->metrics->toArray();

        return ResponseFormatter::formatResponse(
            'success',
            200,
            null,
            [
                'url_data' => $urlData,
                'metrics' => $metrics
            ]
        );
    }
}
