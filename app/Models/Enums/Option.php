<?php

namespace App\Models\Enums;


enum Option: string
{
    case Color = 'color';
    case Weight = 'weight';
    case Width = 'width';
    case Height = 'height';
}