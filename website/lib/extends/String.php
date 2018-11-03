<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of String
 *
 * @author Wendu PC7
 */
class XString {
    //put your code here
    
    //*************************** remplace tous les caractères accentué par leur équivalent et les espace par des underscores et tous caractères autre que alphanumérique est supprimé ***********************

    function filter($in) {
        $in = strtolower($in);
        $search = array('@[éèêëÊË]@i', '@[àâäÂÄ]@i', '@[îïÎÏ]@i', '@[ûùüÛÜ]@i', '@[ôöÔÖ]@i', '@[ç]@i', '@[ ]@i', '@[^a-zA-Z0-9-]@');
        $replace = array('e', 'a', 'i', 'u', 'o', 'c', '-', '');
        $output = preg_replace($search, $replace, $in);
        while (substr($output, 0, 1) == '-')
            $output = substr($output, 1);
        while (substr($output, -1, 1) == '-')
            $output = substr($output, 0, strlen($output) - 1);
        return $output;
    }

    //*************************** génère une chaine aléatoire de "length" caractères ***********************

    function rand_str($length = 32) {
        $characts = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characts .= '1234567890';
        $characts .= 'abcdefghijklmnopqrstuvwxyz';
        $code_aleatoire = '';

        for ($i = 0; $i < $length; $i++) {
            $code_aleatoire .= substr($characts, rand() % (strlen($characts)), 1);
        }
        return $code_aleatoire;
    }

    //*************************** Encode form's input text ***********************

    function encodeV1($str) {
        $search = array("'", '"', '<', '>', '');
        $replace = array('&acute;', '&quot;', '&lt;', '&gt;');
        return str_replace($search, $replace, $str);
    }

    function sql_escape($str) {
        //$search		= array("'",'"','<','>',';',',');
        //$replace	= array('&acute;','&quot;','&lt;','&gt;','','');
        $search = array('#lt;', '#gt;');
        $replace = array('&lt;', '&gt;');
        $str = trim($str);
        return str_replace($search, $replace, $str);
    }

    function escape($str) {
        $search = array("'", '"', '<', '>');
        $replace = array('&acute;', '&quot;', '&lt;', '&gt;');
        return str_replace($search, $replace, $str);
    }

    //*************************** validate url path ***********************
    //function validate_url_path($url,$path)
    function url_validate_path($url, $path) {
        if (substr($path, 0, 4) == 'http')
            return $path;
        if (substr($url, -1, 1) != '/')
            $url .= '/';
        if (substr($path, 0, 1) == '/')
            $path = substr($path, 1);
        return $url . $path;
    }
    
}
