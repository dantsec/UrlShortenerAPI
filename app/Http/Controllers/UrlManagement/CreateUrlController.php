<?php

namespace App\Http\Controllers\UrlManagement;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class CreateUrlController extends Controller
{
    const VALIDATION_RULES = [
        'long_url' => 'required|string|url'
    ];

    const ERROR_MESSAGES = [
        'long_url.required' => 'URL is Required.',
        'long_url.string' => 'URL need to be a String.',
        'long_url.url' => 'URL must be valid.'
    ];

    public function __invoke(Request $request): JsonResponse
    {
        $validationResponse = $this->validateRequest($request->all(), self::VALIDATION_RULES, self::ERROR_MESSAGES);

        if ($validationResponse) {
            return $validationResponse;
        }

        $hash = Url::generateUniqueHash();

        Url::create([
            'hash' => $hash,
            'long_url' => $request->long_url,
            'created_at' => Carbon::now()
        ]);

        return ResponseFormatter::formatResponse(
            'success',
            201,
            'URL Created Successfully',
            ['url' => env('APP_URL') . '/' . $hash]
        );
    }
}
