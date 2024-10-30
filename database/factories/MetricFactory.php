<?php

namespace Database\Factories;

use App\Models\Metric;
use App\Models\Url;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'url_id'           => Url::inRandomOrder()->first()->id,
            'ip_addr'          => $this->faker->ipv4,
            'device_type'      => $this->faker->randomElement(['mobile', 'desktop', 'tablet']),
            'browser_type'     => $this->faker->randomElement(['Chrome', 'Firefox', 'Safari', 'Edge', 'Opera']),
            'operating_system' => $this->faker->randomElement(['Windows', 'macOS', 'Linux', 'iOS', 'Android']),
            'referrer_source'  => $this->faker->randomElement(['Google', 'Facebook', 'Twitter', 'LinkedIn', 'Direct']),
            'created_at'       => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
