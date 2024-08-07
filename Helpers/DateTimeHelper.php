<?php

namespace Helpers;

use DateTime;

class DateTimeHelper
{
    /**
     * @throws \Exception
     */
    public static function stringToDate(string $format, string $date) : DateTime
    {
        $result = DateTime::createFromFormat($format, $date);
        if ($result) {
            return $result;
        }
        throw new \Exception("Invalid date format: $date");
    }
}