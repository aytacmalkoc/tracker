<?php


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tracking>
 */
class TrackingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ipAddress' => $this->faker->unique()->ipv4,
            'referer_url' => $this->faker->url,
            'landing_url' => $this->faker->url,
            'query' => $this->faker->boolean ? \Illuminate\Support\Str::random(30) : null,
            'ad_group' => $this->faker->boolean ? $this->faker->word : null,
            'ads_group' => $this->faker->boolean ? $this->faker->word : null,
            'campaign' => $this->faker->boolean ? $this->faker->word : null,
            'clid' => $this->faker->boolean ? \Illuminate\Support\Str::random(40) : null,
            'country' => $this->faker->country,
            'country_code' => $this->faker->countryCode,
            'city' => $this->faker->city,
            'region' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,
            'timezone' => $this->faker->timezone,
            'language' => $this->faker->locale,
            'languages' => [$this->faker->locale, $this->faker->locale],
            'user_agent' => $this->faker->userAgent,
            'platform' => $this->faker->randomElement(['AndroidOS', 'iOS', 'Windows']),
            'browser' => $this->faker->randomElement(['Chrome', 'Safari', 'Firefox', 'Opera']),
            'version' => $this->faker->randomFloat(),
            'device' => $this->faker->randomElement(['phone', 'desktop', 'tablet']),
            'os' => $this->faker->randomElement(['Linux', 'OS X', 'Windows 10.0']),
            'steps' => [],
            'conversion_date' => null,
            'conversion' => false,
        ];
    }
}
