<?php

return [

    /*
    |--------------------------------------------------------------------------
    | URL Expiration Time
    |--------------------------------------------------------------------------
    |
    | Set default expiration time to 3 days.
    | If the time difference between the request and `created_at` field
    | is greater than or equal to the TTL, it returns that the URL is expired.
    */

    'ttl' => env('URL_TTL', 60 * 60 * 24 * 3),

];
