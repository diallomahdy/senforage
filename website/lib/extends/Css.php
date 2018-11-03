<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Css
 *
 * @author Wendu PC7
 */
class XCss {
    //put your code here
    
    //*************************** css file parser ***********************

    function css_parser($file) {
        $css = file_get_contents($file);
        preg_match_all('/(?ims)([a-z0-9\s\.\:#_\-@,]+)\{([^\}]*)\}/', $css, $arr);
        $result = array();
        foreach ($arr[0] as $i => $x) {
            $selector = trim($arr[1][$i]);
            $rules = explode(';', trim($arr[2][$i]));
            $rules_arr = array();
            foreach ($rules as $strRule) {
                if (!empty($strRule)) {
                    $rule = explode(":", $strRule);
                    $rules_arr[trim($rule[0])] = trim($rule[1]);
                }
            }

            $selectors = explode(',', trim($selector));
            foreach ($selectors as $strSel) {
                $result[$strSel] = $rules_arr;
            }
        }
        return $result;
    }

    //*************************** save a parsed css array ***********************

    function css_save($new_file, $css) {
        $result = '';
        foreach ($css as $sk => $sv) {
            $result .= $sk . '{';
            foreach ($sv as $pk => $pv) {
                $result .= $pk . ':' . $pv . ';';
            }
            $result .= '}';
        }
        file_put_contents($new_file, $result);
    }
    
}
