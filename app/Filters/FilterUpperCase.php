<?php

namespace App\Filters;

use Waavi\Sanitizer\Contracts\Filter;

class FilterUpperCase implements Filter
{
    public $name = 'upper_case';

    public function apply($value, $options = [])
    {
        return strtoupper($value);
    }
}
