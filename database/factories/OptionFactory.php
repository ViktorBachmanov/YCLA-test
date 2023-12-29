<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Arr;

use App\Models\Enums\OptionEnum;
use App\Models\Enums\ColorEnum;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Option>
 */
class OptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pairs' => $this->getRandomPairs(),
        ];
    }

    private function getRandomPairs(): array
    {
        $allTypes = OptionEnum::cases();

        $optionTotal = random_int(1, count($allTypes));

        $types = Arr::random($allTypes, $optionTotal);

        $pairs = [];

        foreach ($types as $type) {
            $pairs[$type->value] = match ($type) {
                OptionEnum::Color => Arr::random(ColorEnum::cases()),
                OptionEnum::Weight => random_int(1, 100),
                OptionEnum::Width => random_int(20, 500),
                OptionEnum::Height => random_int(10, 400),
                OptionEnum::Decor => (bool) random_int(0, 1)
            };
        };

        return $pairs;
    }
}
