<?php

namespace App\Http\Controllers\UrlManagement;

use App\Models\Url;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class GetUrlInfoController extends Controller
{
    const VALIDATION_RULES = [
        'hash' => 'required|string'
    ];

    const ERROR_MESSAGES = [
        'hash.required' => 'Hash is Required.',
        'hash.string' => 'Hash must be a String.'
    ];

    /**
     * Get saved database informations based on hash.
     *
     * @param string $hash
     *
     * @return JsonResponse
     */
    public function __invoke(string $hash): JsonResponse
    {
        $validationResponse = $this->validateRequest(['hash' => $hash], self::VALIDATION_RULES, self::ERROR_MESSAGES);

        if ($validationResponse) {
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

        $urlData = $url->toArray();
        $metrics = $url->metrics->toArray();

        $metrics = array_map(function($metric) {
            unset($metric['id']);
            return $metric;
        }, $metrics);

        return ResponseFormatter::formatResponse(
            'success',
            200,
            'Data Retrieved Successfully',
            [
                'url_data' => $urlData,
                'metrics' => $metrics
            ]
        );
    }
}
