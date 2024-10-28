<?php

namespace App\Http\Controllers\UrlManagement;

use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class CreateUrlController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        // Try to validate request, else throw a expection and return a response with errors.
        try {
            $this->validate($request, [
                'long_url' => 'required|string'
            ], [
                'long_url.required' => 'URL is required.',
                'long_url.string' => 'URL need to be a string.'
            ]);
        } catch (ValidationException $e) {
            return ResponseFormatter::formatResponse(
                'error',
                422,
                'Validation Error',
                $e->errors()
            );
        }

        $hash = Str::random(10);

        Url::create([
            'hash' => $hash,
            'long_url' => $request->long_url,
            'created_at' => Carbon::now()
        ]);

        return ResponseFormatter::formatResponse(
            'success',
            201,
            null,
            ['url' => env('APP_URL') . '/' . $hash]
        );
    }
}
