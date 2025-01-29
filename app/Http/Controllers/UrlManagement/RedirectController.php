<?php

namespace App\Http\Controllers\UrlManagement;

use App\Helpers\MetricDataHandler;
use App\Models\Url;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Metric;
use Illuminate\Support\Facades\Log;

class RedirectController extends Controller
{
    private const VALIDATION_RULES = [
        'hash' => 'required|string'
    ];

    private const ERROR_MESSAGES = [
        'hash.required' => 'Hash is Required.',
        'hash.string' => 'Hash must be a String.'
    ];

    /**
     * Redirect user to original url based on saved hash at database and save its metric.
     *
     * @param string $hash
     *
     * @return JsonResponse
     */
    public function __invoke(string $hash): JsonResponse
    {
        $validationResponse = $this->validateRequest(['hash' => $hash], self::VALIDATION_RULES, self::ERROR_MESSAGES);

        if ($validationResponse instanceof JsonResponse) {
            return $validationResponse;
        }

        $url = Url::findByHash($hash);

        $longUrl = $url?->long_url;

        if (!isset($longUrl)) {
            return ResponseFormatter::formatResponse(
                'error',
                404,
                'URL Not Found',
            );
        }

        if ($url->isExpired()) {
            return ResponseFormatter::formatResponse(
                'error',
                410,
                'URL Expired',
            );
        }

        $url->increment('total_clicks');

        Log::info('(URL): URL click count incremented.', [
            'hash' => $hash,
            'total_clicks' => $url->total_clicks
        ]);

        Metric::create(MetricDataHandler::metricDataFormatter($url->id, $_SERVER, $url->total_clicks));

        Log::info('(METRIC): Metric data recorded.', ['hash' => $hash]);

        return ResponseFormatter::formatResponse(
            'success',
            302,
            'Redirecting to Long URL',
            ['redirect' => true],
            ['Location' => $longUrl]
        );
    }
}
