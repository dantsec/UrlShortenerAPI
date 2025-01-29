<?php

namespace App\Traits;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

trait RequestHandlerTrait
{
    /**
     * Validate a HTTP request based on gave rules and messages.
     *
     * @param Request
     * @param array
     * @param array
     *
     * @return null|JsonResponse
     *
     * @throws ValidationException
     */
    public function validateRequest(array $data, array $rules, array $messages): JsonResponse|array
    {
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return ResponseFormatter::formatResponse(
                'error',
                422,
                'Validation Error',
                $validator->errors()->toArray()
            );
        }

        return $validator->validate();
    }
}
