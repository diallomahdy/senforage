<?php

class PHPArray {
    
    public static function getKeyByValue(String $needle, array $haystack, bool $strict=NULL) {
        foreach ($haystack as $key => $value) {
            if(is_array($value)){
                if(in_array($needle, $value, $strict)){
                    return $key;
                }
            }
        }
        return false;
    }
    
}

