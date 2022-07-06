<?php

namespace App\Filters;

use Waavi\Sanitizer\Contracts\Filter;

class FilterString implements Filter
{
    public $name = 'filter_string';

    public function apply($value, $options = [])
    {
        if (is_null($value) || !count($options)) {
            return null;
        }

        return str_replace($options, '', $value);
    }
}
