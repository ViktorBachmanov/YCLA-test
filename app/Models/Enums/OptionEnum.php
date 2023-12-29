<?php

namespace App\Models\Enums;

use Illuminate\Support\Arr;


enum OptionEnum: string
{
    case Color = 'color';
    case Weight = 'weight';
    case Width = 'width';
    case Height = 'height';
    case Decor = 'decor';


    public function getRandomValue(): ColorEnum|int|bool
    {
        return match ($this) {
            OptionEnum::Color => Arr::random(ColorEnum::cases()),
            OptionEnum::Weight => random_int(1, 100),
            OptionEnum::Width => random_int(20, 500),
            OptionEnum::Height => random_int(10, 400),
            OptionEnum::Decor => (bool) random_int(0, 1)
        };
    }
}