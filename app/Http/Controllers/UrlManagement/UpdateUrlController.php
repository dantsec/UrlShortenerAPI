<?php

namespace App\Http\Controllers\UrlManagement;

use App\Models\Url;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UpdateUrlController extends Controller
{
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
        // Try to validate request, else throw a expection and return a response with errors.
        try {
            $this->validate($request, ['long_url' => 'required|string'], [
                'long_url.required' => 'URL is Required.',
                'long_url.string' => 'URL need to be a String.'
            ]);
        } catch (ValidationException $e) {
            return ResponseFormatter::formatResponse(
                'error',
                422,
                'Validation Error',
                $e->errors()
            );
        }

        $url = Url::findByHash($hash);

        if (!isset($url)) {
            return ResponseFormatter::formatResponse(
                'error',
                404,
                'URL Not Found',
            );
        }

        $url->update(['long_url' => $request->long_url]);

        return ResponseFormatter::formatResponse(
            'success',
            200,
            'URL Updated Successfully',
            [$url->toArray()]
        );
    }
}
