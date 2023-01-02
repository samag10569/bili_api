<?php

namespace Classes;

class DateUtils
{
    public static function getCurrentMonth($currentMonth = 0, $justMonth = true)
    {
        // date start and end current month or back month
        date_default_timezone_set('Asia/Tehran');

        $arrJalali = jgetdate(strtotime(date('Y/m/d')));

        $month = intval($arrJalali['mon']);
        $pre_month = 1;
        $year = $arrJalali['year'];

        if ($month <= $currentMonth) {
            $pre_month = 12 - ($currentMonth - $month);
            $year--;
        } else {
            $pre_month = $month - $currentMonth;
        }

        if ($justMonth) {
            $next_month = $pre_month + 1;
        } else {
            $next_month = $month;
        }
        $start_date = jmktime('0', '0', '0', $pre_month, '1', $year);
        if ($next_month == 13) {
            $end_date = jmktime('0', '0', '0', 1, '1', $arrJalali['year']);
        } else {
            $end_date = jmktime('0', '0', '0', $next_month, '1', $arrJalali['year']);

        }

        return ['start_date' => $start_date,
            'end_date' => $end_date];
    }

    public static function current_date($back = 0)
    {
        // date start and end current day or back day
        $time = time() - ($back * 86400);
        $y = jdate('13y', $time);
        $m = jdate('m', $time);
        $d = jdate('d', $time);

        $y_1 = jdate('13y', $time + (1 * 86400));
        $m_1 = jdate('m', $time + (1 * 86400));
        $d_1 = jdate('d', $time + (1 * 86400));

        $date['start_date'] = jmktime(0, 0, 0, $m, $d, $y);
        $date['end_date'] = jmktime(0, 0, 0, $m_1, $d_1, $y_1);

        return $date;
    }
}