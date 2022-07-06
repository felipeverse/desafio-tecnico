<?php

namespace App\Filters;

use Waavi\Sanitizer\Contracts\Filter;

class Timezone implements Filter
{
    public $name = 'timezone';

    public function apply($value, $options = [])
    {
        if (is_numeric($value[0])) {
            $value = '+' . $value;
        }

        return $value;
    }
}
