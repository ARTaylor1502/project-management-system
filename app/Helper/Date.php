<?php

namespace App\Helper;

use DateTime;

class Date
{
    public static function isPastDate($date) {
        $today_date = new DateTime(date('Y-m-d'));
        $comparison_date = new DateTime($date);

        if ($comparison_date < $today_date) {
            return true;
        } else {
            return false;
        }
    }

    public function getTimeUntilDate($date) {
        return date_diff(date_create($date), now());
    }
}