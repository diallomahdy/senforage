<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Helper
 *
 * @author Wendu PC7
 */
class Helper {
    
    public static function getKeyByValue($needle, $haystack, $strict=NULL) {
        foreach ($haystack as $key => $value) {
            if(is_array($value)){
                if(in_array($needle, $value, $strict)){
                    return $key;
                }
            }
        }
        return false;
    }
    
    public static function getDate($date) {
        setlocale(LC_TIME, 'fra_fra');
        //setlocale(LC_TIME, "fr_FR");
        /*$dStart = new DateTime($date);
        $dDiff = $dStart->diff(new DateTime(date('Y-m-d H:i:s')));
        if ($dDiff->y) {
            return strftime("%d %B %Y", strtotime($date));
        } elseif ($dDiff->m) {
            return strftime("%d %B, %H:%M", strtotime($date));
        } elseif ($dDiff->days) {
            return strftime("%A %d, %H:%M", strtotime($date));
        } else {
            return strftime("%H:%M", strtotime($date));
        }*/
        return utf8_encode(strftime("%d %B %Y", strtotime($date)));
    }
    
}
