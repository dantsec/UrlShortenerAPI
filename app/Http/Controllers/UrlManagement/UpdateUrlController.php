<?php

namespace App\Http\Controllers\UrlManagement;

use App\Models\Url;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateUrlController extends Controller
{
    private const VALIDATION_RULES = [
        'long_url' => 'required|string|url',
        'hash' =>  'required|string'
    ];

    private const ERROR_MESSAGES = [
        'long_url.required' => 'URL is Required.',
        'long_url.string' => 'URL need to be a String.',
        'long_url.url' => 'URL must be valid.',
        'hash.required' => 'Hash is Required.',
        'hash.string' => 'Hash must be a String.'
    ];

    /**
     * Update URL and return it with updated data.
     *
     * @param string $hash
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(string $hash, Request $request): JsonResponse
    {
        $validationResponse = $this->validateRequest(
            $request->all() + ['hash' => $hash],
            self::VALIDATION_RULES,
            self::ERROR_MESSAGES
        );

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

        if ($url->isExpired()) {
            return ResponseFormatter::formatResponse(
                'error',
                410,
                'URL Expired',
            );
        }

        $url->update(['long_url' => $request->long_url]);

        Log::info('(URL): URL updated successfully.', [
            'hash' => $hash,
            'updated_url' => $request->long_url
        ]);

        return ResponseFormatter::formatResponse(
            'success',
            200,
            'URL Updated Successfully',
            [$url->toArray()]
        );
    }
}
