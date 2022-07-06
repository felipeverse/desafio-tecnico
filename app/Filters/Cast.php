<?php

namespace App\Filters;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Collection;
use Waavi\Sanitizer\Contracts\Filter;

class Cast implements Filter
{
    public $name = 'cast';

    public function apply($value, $options = [])
    {
        if (is_null($value)) {
            return $value;
        }

        $type = trim(strtolower($options[0]));

        switch ($type) {
            case 'int':
            case 'integer':
                return (int) $value;
            case 'real':
            case 'float':
            case 'double':
                return (float) $value;
            case 'string':
                return (string) $value;
            case 'bool':
            case 'boolean':
                return (bool) $value;
            case 'object':
                return $this->fromJson($value, true);
            case 'array':
            case 'json':
                return $this->fromJson($value);
            case 'collection':
                return new Collection($this->fromJson($value));
            case 'carbon':
            case 'date':
            case 'datetime':
                return $this->asDateTime($value, $options);
            case 'timestamp':
                return $this->asTimeStamp($value);
            case 'money':
                return (float) money_to_float($value);
            case 'decimal':
                return format_decimal($value);
            default:
                return $value;
        }
    }

    /**
     * Return a timestamp as DateTime object.
     *
     * @param  mixed  $value
     * @return \Carbon\Carbon
     */
    protected function asDateTime($value, $options = [])
    {
        // If this value is already a Carbon instance, we shall just return it as is.
        // This prevents us having to re-instantiate a Carbon instance when we know
        // it already is one, which wouldn't be fulfilled by the DateTime check.
        if ($value instanceof Carbon) {
            return $this->handleCarbon($value);
        }

         // If the value is already a DateTime instance, we will just skip the rest of
         // these checks since they will be a waste of time, and hinder performance
         // when checking the field. We will just return the DateTime right away.
        if ($value instanceof DateTimeInterface) {
            $date = new Carbon(
                $value->format('Y-m-d H:i:s.u'),
                $value->getTimeZone()
            );
            return $this->handleCarbon($date);
        }

        // If this value is an integer, we will assume it is a UNIX timestamp's value
        // and format a Carbon object from this timestamp. This allows flexibility
        // when defining your date fields as they might be UNIX timestamps here.
        if (is_numeric($value)) {
            $date = Carbon::createFromTimestamp($value);
            return $this->handleCarbon($date);
        }

        if (isset($options[1])) {
            $date = Carbon::createFromFormat($options[1], $value);
            if (!preg_match('/H|i|s|u/', $options[1])) {
                $date->startOfDay();
            }
            return $this->handleCarbon($date);
        }

        // If the value is in simply year, month, day format, we will instantiate the
        // Carbon instances from that format. Again, this provides for simple date
        // fields on the database, while still supporting Carbonized conversion.
        if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value)) {
            $date = Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
            return $this->handleCarbon($date);
        }

        // Finally, we will just assume this date is in the format used by default on
        // the database connection and use that format to create the Carbon object
        // that is returned back out to the developers after we convert it here.
        $date = Carbon::parse($value);
        return $this->handleCarbon($date);
    }

    /**
     * Return a timestamp as unix timestamp.
     *
     * @param  mixed  $value
     * @return int
     */
    protected function asTimeStamp($value)
    {
        return $this->asDateTime($value)->getTimestamp();
    }

    /**
     * Decode the given JSON back into an array or object.
     *
     * @param  string  $value
     * @param  bool  $asObject
     * @return mixed
     */
    public function fromJson($value, $asObject = false)
    {
        return json_decode(json_encode($value), ! $asObject);
    }

    /**
     * Set the app's default timezone for all dates
     *
     * @param  Carbon $carbon
     *
     * @return Carbon
     */
    private function handleCarbon(Carbon $carbon): Carbon
    {
        return $carbon->setTimezone(config('app.timezone'));
    }
}
