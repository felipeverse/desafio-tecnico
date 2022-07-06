<?php

namespace App\Filters;

use Waavi\Sanitizer\Contracts\Filter;

class TrimNull implements Filter
{
    public $name = 'trim_null';

    public function apply($value, $options = [])
    {
        $value = trim($value);

        return strlen($value) && strtolower($value) !== 'null' ? $value : null;
    }
}
