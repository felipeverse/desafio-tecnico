<?php

namespace App\Filters;

use Waavi\Sanitizer\Contracts\Filter;

class OnlyNumber implements Filter
{
    public $name = 'only_number';

    public function apply($value, $options = [])
    {
        $value = trim($value);

        return preg_replace('/\D/', '', $value);
    }
}
