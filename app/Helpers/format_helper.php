<?php

if (!function_exists('formatted_date')) {
    /**
     * Formats a date
     *
     * @param string $format
     * @param null $date
     * @return false|string
     */
    function format_date(string $format='Y-m-d H:i:s', $date = null)
    {
        return date($format, strtotime($date));
    }
}