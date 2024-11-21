<?php

namespace Database\Factories;

use App\Models\Url;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UrlFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Url::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hash'         => Str::random(10),
            'long_url'     => $this->faker->url(),
            'total_clicks' => $this->faker->numberBetween(0, 5000),
            'expired_at'   => $this->faker->randomElement([$this->faker->dateTime(), null])
        ];
    }
}
