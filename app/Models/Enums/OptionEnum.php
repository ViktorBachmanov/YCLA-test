<?php

namespace App\Models\Enums;


enum OptionEnum: string
{
    case Color = 'color';
    case Weight = 'weight';
    case Width = 'width';
    case Height = 'height';
    case Decor = 'decor';
}