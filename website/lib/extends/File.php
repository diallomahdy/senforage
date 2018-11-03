<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of File
 *
 * @author Wendu PC7
 */
class XFile {
    //put your code here
    public $name = '';
    public $path = '';
    public $fullPath = '';
    public $extension = '';
    public $isDir = false;
    
    function setFile($file){
        if($file){
            $this->fullPath = $file;
        }
        elseif($this->$fullPath!=''){
            if($this->path!='' || $this->name!=''){
                $file = $this->path . '/' . $this->name;
            }
        }
    }
    
    function getExtension($file = false) {
        list($txt, $ext) = explode('.', $file);
        $ext = strtolower($ext);
        return $ext;
    }
    
    //*************************** get a file or directory size ***********************

    function getSize($file = false) {
        $size = 0;
        // If now file given then get current object as file
        // Case file
        if (is_file($file)) {
            $size = filesize($file);
        }
        // Case directory
        elseif (is_dir($file)) {
            // add trailing slash
            if (substr($file, -1) != "/")
                $file .= "/";
            // open directory
            if ($dir_id = opendir($file)) {
                // loop through contents of dir
                while (($item = readdir($dir_id)) !== false) {
                    // if item does not equal "." and ".."
                    if ($item != "." && $item != "..") {
                        // if item is a directory
                        if (is_dir($dir . $item)) {
                            // call function recursively
                            $size += dirSize($dir . $item);
                            // else item is a file
                        } else {
                            // add size of file
                            $size += filesize($dir . $item);
                        }
                    }
                }
                closedir($file);
            }
        }
        return $size;
    }

    // Remove recursively a directory
    function deleteDir($dir) {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!deleteDir($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }

    //*************************** formatter octets ***********************

    function formatFileSize($res) {
        if (!is_numeric($res))
            $size = filesize($res);
        else
            $size = $res;
        $unit = 'B';
        if ($size > 1000) {
            $unit = 'KB';
            $size = floor($size / 1000);
        }
        if ($size > 1000) {
            $unit = 'MB';
            $size = floor($size / 1000);
        }
        return $size . ' ' . $unit;
    }

    //*************************** find ***********************

    function fileFinder($expression, $Directory) {
        $array[0] = 0;
        if (is_dir($Directory)) {
            $MyDirectory = opendir($Directory);
            while ($Entry = readdir($MyDirectory)) {
                //fileFider($expression,$Directory.'/'.$Entry);
                if (mb_eregi($expression, $Entry)) {
                    //$array[]=$Directory.'/'.$Entry;
                    $array[] = $Entry;
                }
            }
            closedir($MyDirectory);
        }
        return $array;
    }

    //*************************** serach file by string ***********************

    function getFileByStr($str) {
        $str .= '*';
        if ($array = glob($str)) {
            $count = count($array);
            if ($count > 1)
                return $array[1];
            else if ($count == 1)
                return $array[0];
            else
                return false;
        } else
            return false;
    }
    
    //*************************** upload file ***********************

    function file_upload($file_input, $path, $file_name) {
        $name = basename($file_input['name']);
        if ($name == '')
            return '';
        //list($txt, $ext) = explode('.', $name);
        //$ext = strtolower($ext);
        $ext = strrchr($name, '.');
        $file_full_name = $file_name . $ext;
        $tmp = $file_input['tmp_name'];
        if (move_uploaded_file($tmp, $path . '/' . $file_full_name)) {
            return $file_full_name;
        }
        return false;
    }
    
    //***************************** Download file ******************

function download_file($fullPath) {

    // Must be fresh start
    if (headers_sent())
        die('Headers Sent');

    // Required for some browsers
    if (ini_get('zlib.output_compression'))
        ini_set('zlib.output_compression', 'Off');

    // File Exists?
    if (file_exists($fullPath)) {

        // Parse Info / Get Extension
        $fsize = filesize($fullPath);
        $path_parts = pathinfo($fullPath);
        $ext = strtolower($path_parts["extension"]);

        // Determine Content Type
        switch ($ext) {
            case "pdf": $ctype = "application/pdf";
                break;
            case "exe": $ctype = "application/octet-stream";
                break;
            case "zip": $ctype = "application/zip";
                break;
            case "doc": $ctype = "application/msword";
                break;
            case "xls": $ctype = "application/vnd.ms-excel";
                break;
            case "ppt": $ctype = "application/vnd.ms-powerpoint";
                break;
            case "gif": $ctype = "image/gif";
                break;
            case "png": $ctype = "image/png";
                break;
            case "jpeg":
            case "jpg": $ctype = "image/jpg";
                break;
            default: $ctype = "application/force-download";
        }

        header("Pragma: public"); // required
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false); // required for certain browsers
        header("Content-Type: $ctype");
        header("Content-Disposition: attachment; filename=\"" . basename($fullPath) . "\";");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $fsize);
        ob_clean();
        flush();
        readfile($fullPath);
    } else
        die('File Not Found');
}
    
}
