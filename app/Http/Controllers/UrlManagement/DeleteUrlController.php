<?php

namespace App\Http\Controllers\UrlManagement;

use App\Models\Url;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class DeleteUrlController extends Controller
{
    /**
     * Delete url and it's metrics completely.
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

        $url->deleteOrFail();

        return ResponseFormatter::formatResponse(
            'success',
            200,
            'Data Deleted Successfully'
        );
    }
}
