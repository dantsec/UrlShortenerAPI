<?php

namespace App\Http\Controllers\UrlManagement;

use App\Models\Url;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class DeleteUrlController extends Controller
{
    private const VALIDATION_RULES = [
        'hash' => 'required|string'
    ];

    private const ERROR_MESSAGES = [
        'hash.required' => 'Hash is Required.',
        'hash.string' => 'Hash must be a String.'
    ];

    /**
     * Delete url and it's metrics completely.
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

        if (!isset($url)) {
            return ResponseFormatter::formatResponse(
                'error',
                404,
                'URL Not Found',
            );
        }

        $url->deleteOrFail();

        Log::info('(URL): URL deleted successfully.', ['hash' => $hash]);

        return ResponseFormatter::formatResponse(
            'success',
            200,
            'Data Deleted Successfully'
        );
    }
}
