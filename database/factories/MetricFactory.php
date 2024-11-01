<?php

namespace Database\Factories;

use App\Models\Metric;
use App\Models\Url;
use Illuminate\Database\Eloquent\Factories\Factory;
use Jenssegers\Agent\Agent;

class MetricFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Metric::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $agent = new Agent();
        $agent->setUserAgent($this->faker->userAgent());

        return [
            'url_id'           => Url::inRandomOrder()->first()->id,
            'ip_addr'          => $this->faker->ipv4,
            'device_type'      => $agent->deviceType(),
            'browser_type'     => $agent->browser(),
            'operating_system' => $agent->platform(),
            'referrer_source'  => $this->faker->randomElement([$this->faker->url(), 'Direct']),
            'created_at'       => $this->faker->dateTimeBetween('-1 year', 'now'),
            'total_clicks'     => $this->faker->numberBetween(0, 5000),
            'user_agent'       => $agent->getUserAgent()
        ];
    }
}
