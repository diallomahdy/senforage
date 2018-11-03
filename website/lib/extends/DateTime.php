<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateTime
 *
 * @author Wendu PC7
 */

class XDateTime {
    //put your code here
    
    function diffDay($date1,$date2){
        $s = strtotime($date1)-strtotime($date2);
        return intval($s/86400);
    }
    
    //*************************** get date litteral format ***********************
    
    function get_date_($date, $translation){}

    function get_date($date, $translation) {
        $diff_time = '';

        $current_y = intval(date('Y'));
        $year = intval(substr($date, 0, 4));
        $diff_y = $current_y - $year;

        $current_m = intval(date('m'));
        $month = intval(substr($date, 5, 2));
        $diff_m = $current_m - $month;

        $current_d = intval(date('d'));
        $day = intval(substr($date, 8, 2));
        $diff_d = $current_d - $day;

        $current_h = intval(date('H'));
        $hour = intval(substr($date, 11, 2));
        $diff_h = $current_h - $hour;

        $current_mn = intval(date('i'));
        $minute = intval(substr($date, 14, 2));
        $diff_mn = $current_mn - $minute;

        if ($day < 10)
            $str_d = '0' . $day;
        else
            $str_d = $day;
        if ($hour < 10)
            $str_h = '0' . $hour;
        else
            $str_h = $hour;
        if ($minute < 10)
            $str_mn = '0' . $minute;
        else
            $str_mn = $minute;

        if ($diff_y)
            $diff_time = $str_d . ' ' . $translation['month-' . $month] . ' ' . $year;
        elseif ($diff_m)
            $diff_time = $str_d . ' ' . $translation['FullMonth-' . $month];
        elseif (abs($diff_d) > 1) {
            $wday = 1 + (int) date("w", mktime(0, 0, 0, $month, $day, $year));
            $diff_time = $translation['day-' . $wday] . ' ' . $str_d;
        } elseif (abs($diff_d) == 1) {
            $diff_time = $translation['yesterday_at'] . ' ' . $str_h . ':' . $str_mn;
        } else if ($diff_h || $diff_mn)
            $diff_time = $str_h . ':' . $str_mn;
        else
            $diff_time = $translation['some_seconds'];
        return $diff_time;
    }

    function get_diff_time($date, $month_array, $day_array = NULL) {
        $diff_time = '';

        $current_y = intval(date('Y'));
        $year = intval(substr($date, 0, 4));
        $diff_y = $current_y - $year;

        $current_m = intval(date('m'));
        $month = intval(substr($date, 5, 2));
        $diff_m = $current_m - $month;

        $current_d = intval(date('d'));
        $day = intval(substr($date, 8, 2));
        $diff_d = $current_d - $day;

        $current_h = intval(date('H'));
        $hour = intval(substr($date, 11, 2));
        $diff_h = $current_h - $hour;

        $current_mn = intval(date('i'));
        $minute = intval(substr($date, 14, 2));
        $diff_mn = $current_mn - $minute;

        if ($day < 10)
            $str_d = '0' . $day;
        else
            $str_d = $day;
        if ($hour < 10)
            $str_h = '0' . $hour;
        else
            $str_h = $hour;
        if ($minute < 10)
            $str_m = '0' . $minute;
        else
            $str_m = $minute;

        if (abs($diff_m) > 1)
            $diff_time .= $str_d . ' ' . $month_array[$month - 1] . ' à ';
        else {
            if (abs($diff_d) > 1)
            //$diff_time.=date("w", strtotime($year."-".$month."-".$day)).' '.$str_d.' à ';
            //$diff_time.=$day_array[intval(date("w", strtotime($year."-".$month."-".$day)))].' '.$str_d.' à ';
                $diff_time .= $str_d . ' ' . $month_array[$month - 1] . ' à ';
            else if (abs($diff_d) == 1)
                $diff_time .= 'Hier à ';
        }
        if ($diff_time != '')
            $diff_time .= $str_h . ':' . $str_m;
        else {
            if (abs($diff_h) > 1)
                $diff_time .= $str_h . ':' . $str_m;
            else if (abs($diff_h) == 1) {
                $diff_mn2 = 60 - $minute + $current_mn;
                if ($diff_mn2 > 59)
                    $diff_time .= $str_h . ':' . $str_m;
                else
                    $diff_time .= 'Il y’a ' . $diff_mn2 . ' minutes';
            }
            else if ($diff_mn != 0)
                $diff_time .= 'Il y’a ' . $diff_mn . ' minutes';
            else
                $diff_time .= 'Il y’a quelques secondes';
        }
        return $diff_time;
        //return $date.' # '.$diff_time;
    }

    //****************** transformer une chaine numerique de 6 à 8 caractères (commençant par l'année) en une date de type yyyy-mm-dd ******

    function formatDate($date) {
        $y = substr($date, 0, 4);
        if (strlen($date) == 6) {
            $m = '0' . substr($date, 4, 1);
            $d = '0' . substr($date, 5, 1);
        } else if (strlen($date) == 8) {
            $m = substr($date, 4, 2);
            $d = substr($date, 6, 2);
        } else if (strlen($date) == 7) {
            $m = substr($date, 4, 2);
            $d = substr($date, 5, 2);
            if (intval($m) <= 12) {
                $d = '0' . substr($date, 6, 1);
            } else if (intval($d) <= 31) {
                $m = '0' . substr($date, 4, 1);
            } else
                return false;
        }
        return $y . '-' . $m . '-' . $d;
    }

    //****************** transformer une chaine numerique de 6 à 8 caractères (commençant par le jour) en une date de type yyyy-mm-dd ******

    function formatDate2($date) {
        $y = substr($date, -4);
        if (strlen($date) == 6) {
            $m = '0' . substr($date, 1, 1);
            $d = '0' . substr($date, 0, 1);
        } else if (strlen($date) == 8) {
            $m = substr($date, 2, 2);
            $d = substr($date, 0, 2);
        } else if (strlen($date) == 7) {
            $m = substr($date, 1, 2);
            $d = substr($date, 0, 2);
            if (intval($m) <= 12) {
                $d = '0' . substr($date, 0, 1);
            } else if (intval($d) <= 31) {
                $m = '0' . substr($date, 2, 1);
            } else
                return false;
        }
        return $y . '-' . $m . '-' . $d;
    }
    
}
