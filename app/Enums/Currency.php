<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Options;

enum Currency: string
{
    use InvokableCases, Names, Options;

    case USD = 'USD';
    // case PEN = 'PEN';

}
