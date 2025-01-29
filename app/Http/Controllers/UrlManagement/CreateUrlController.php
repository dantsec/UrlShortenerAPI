<?php

namespace App\Http\Controllers\UrlManagement;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CreateUrlController extends Controller
{
    private const VALIDATION_RULES = [
        'long_url' => 'required|string|url'
    ];

    private const ERROR_MESSAGES = [
        'long_url.required' => 'URL is Required.',
        'long_url.string' => 'URL need to be a String.',
        'long_url.url' => 'URL must be valid.'
    ];

    public function __invoke(Request $request): JsonResponse
    {
        $validationResponse = $this->validateRequest($request->all(), self::VALIDATION_RULES, self::ERROR_MESSAGES);

        if ($validationResponse instanceof JsonResponse) {
            return $validationResponse;
        }

        $hash = Url::generateUniqueHash();

        Url::create([
            'hash' => $hash,
            'long_url' => $request->long_url
        ]);

        Log::info('(URL): URL created successfully.', [
            'hash' => $hash,
            'long_url' => $request->long_url
        ]);

        return ResponseFormatter::formatResponse(
            'success',
            201,
            'URL Created Successfully',
            ['url' => env('APP_URL') . '/' . $hash]
        );
    }
}
