<?php

namespace App\Filters;

use Waavi\Sanitizer\Contracts\Filter;

class JsonDecode implements Filter
{
    public $name = 'json_decode';

    public function apply($value, $options = [])
    {
        $value = json_decode($value);

        return $value;
    }
}
