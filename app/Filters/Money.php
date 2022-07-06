<?php

namespace App\Filters;

use Waavi\Sanitizer\Contracts\Filter;

class Money implements Filter
{
    public $name = 'money';

    public function apply($value, $options = [])
    {
        if (is_null($value)) {
            return $value;
        }

        return money_to_float($value);
    }
}
