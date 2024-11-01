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
     * @param int $clicks
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
            'device_type' => $agent->deviceType() ?: 'Unknown',
            'browser_type' => $agent->browser() ?: 'Unknown',
            'operating_system' => $agent->platform() ?: 'Unknown',
            'referrer_source' => $referrerSource,
            'created_at' => Carbon::now(),
            'user_agent' => $agent->getUserAgent()
        ];
    }
}
