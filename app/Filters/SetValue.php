<?php

namespace App\Filters;

use Waavi\Sanitizer\Contracts\Filter;

class SetValue implements Filter
{
    public $name = 'set_value';

    public function apply($value, $options = [])
    {
        $value = count($options) ? $options[0] : null;

        return $value[0];
    }
}
