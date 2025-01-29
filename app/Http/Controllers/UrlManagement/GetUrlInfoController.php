<?php

namespace App\Http\Controllers\UrlManagement;

use App\Models\Url;
use App\Services\MetricService;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class GetUrlInfoController extends Controller
{
    private const FILTER_FIELDS = [
        'ip_addr',
        'device_type',
        'browser_type',
        'operating_system',
        'referrer_source',
        'user_agent'
    ];

    private const VALIDATION_RULES = [
        'hash' => 'required|string',
        'sort_by' => 'nullable|string|in:created_at, ip_addr,device_type,browser_type,operating_system,referrer_source,user_agent',
        'order' => 'nullable|string|in:asc,desc',
        'per_page' => 'nullable|integer|min:1|max:100',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'ip_addr' => 'nullable|string',
        'device_type' => 'nullable|string',
        'browser_type' => 'nullable|string',
        'operating_system' => 'nullable|string',
        'referrer_source' => 'nullable|string',
        'user_agent' => 'nullable|string'
    ];

    private const ERROR_MESSAGES = [
        'hash.required' => 'Hash is required.',
        'hash.string' => 'Hash must be a string.',
        'sort_by.string' => 'Sort by must be a string.',
        'sort_by.in' => 'Sort by must be one of the following: created_at, ip_addr,device_type,browser_type,operating_system,referrer_source,user_agent',
        'order.string' => 'Order must be a string.',
        'order.in' => 'Order must be either "asc" or "desc".',
        'per_page.integer' => 'Per page must be an integer.',
        'per_page.min' => 'Per page must be at least 1.',
        'per_page.max' => 'Per page cannot exceed 100.',
        'start_date.date' => 'Start date must be a valid date.',
        'end_date.date' => 'End date must be a valid date.',
        'end_date.after_or_equal' => 'End date must be on or after the start date.',
        'ip_addr.string' => 'IP address must be a string.',
        'device_type.string' => 'Device type must be a string.',
        'browser_type.string' => 'Browser type must be a string.',
        'operating_system.string' => 'Operating system must be a string.',
        'referrer_source.string' => 'Referrer source must be a string.',
        'user_agent.string' => 'User agent must be a string.'
    ];


    /**
     * Get saved database informations based on hash.
     *
     * @param string $hash
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request, string $hash): JsonResponse
    {
        $validationResponse = $this->validateRequest(
            $request->all() + ['hash' => $hash],
            self::VALIDATION_RULES,
            self::ERROR_MESSAGES
        );

        if ($validationResponse instanceof JsonResponse) {
            return $validationResponse;
        }

        $url = Url::findByHash($hash);

        if (!isset($url)) {
            return ResponseFormatter::formatResponse(
                'error',
                404,
                'URL Not Found',
            );
        }

        $urlData = $url->makeHidden(['id'])->toArray();

        $metrics = (new MetricService())->getFilteredMetrics($url, $validationResponse, self::FILTER_FIELDS);

        Log::info('(URL): URL info retrieved successfully.', [
            'hash' => $hash,
            'url_data' => $urlData,
            'filters' => $validationResponse
        ]);

        return ResponseFormatter::formatResponse(
            'success',
            200,
            'Data Retrieved Successfully',
            [
                'url_data' => $urlData,
                'metrics' => $metrics->setCollection(
                    $metrics
                        ->getCollection()
                        ->map
                        ->makeHidden(['id', 'url_id'])
                )
            ]
        );
    }
}
