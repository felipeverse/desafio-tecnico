<?php

namespace App\Filters;

use Waavi\Sanitizer\Contracts\Filter;

class DecodeHash implements Filter
{
    public $name = 'decode_hash';

    public function apply($value, $options = [])
    {
        return decode_hash($value);
    }
}
