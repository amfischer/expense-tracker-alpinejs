<?php

namespace App\Enums;

use ArchTech\Enums\Names;
use ArchTech\Enums\Options;

enum Currency: string
{
    use Names, Options;

    case USD = 'USD';
    // case PEN = 'PEN';

}