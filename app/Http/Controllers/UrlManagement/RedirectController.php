<?php

namespace App\Http\Controllers\UrlManagement;

use App\Helpers\MetricDataHandler;
use App\Models\Url;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Metric;

class RedirectController extends Controller
{
    /**
     * Redirect user to original url based on saved hash at database and save its metric.
     *
     * @param string $hash
     *
     * @return JsonResponse
     */
    public function __invoke(string $hash): JsonResponse
    {
        $url = Url::findByHash($hash);

        $longUrl = $url?->long_url;

        if (!isset($longUrl)) {
            return ResponseFormatter::formatResponse(
                'error',
                404,
                'URL Not Found',
            );
        }

        $url->increment('total_clicks');

        Metric::create(MetricDataHandler::metricDataFormatter($url->id, $_SERVER, $url->total_clicks));

        return ResponseFormatter::formatResponse(
            'success',
            302,
            'Redirecting to the long URL',
            ['redirect' => true],
            ['Location' => $longUrl]
        );
    }
}
