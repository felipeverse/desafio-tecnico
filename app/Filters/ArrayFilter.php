<?php

namespace App\Filters;

use Exception;
use Waavi\Sanitizer\Contracts\Filter;

class ArrayFilter implements Filter
{
    public $name = 'array_filter';

    public function apply($value, $options = [])
    {
        if (!is_array($value)) {
            throw new Exception('The value is not an array');
        }

        return array_filter($value);
    }
}
