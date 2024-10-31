<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;
use Jenssegers\Agent\Agent;

class MetricDataHandler
{
    /**
     * Create array with formatted `$_SERVER` data.
     *
     * @param int $urlId
     * @param array $data
     *
     * @return array
     */
    public static function metricDataFormatter(int $urlId, array $data): array
    {
        $agent = new Agent();
        $agent->setUserAgent($data['HTTP_USER_AGENT']);

        $ipAddr = $data['HTTP_X_FORWARDED_FOR']
            ?? $data['REMOTE_ADDR']
            ?? '0.0.0.0';

        $referrerSource = $data['HTTP_REFERER'] ?? 'Direct';

        return [
            'url_id' => $urlId,
            'ip_addr' => $ipAddr,
            'device_type' => $agent->deviceType(),
            'browser_type' => $agent->browser(),
            'operating_system' => $agent->platform(),
            'referrer_source' => $referrerSource,
            'created_at' => Carbon::now()
        ];
    }
}
