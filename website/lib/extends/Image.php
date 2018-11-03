<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Image
 *
 * @author Wendu PC7
 */
class XImage {
    //put your code here
    
    //*************************** return an image array contained in web page from a given url ***********************
    //require dirname(__FILE__) . '/simple_html_dom.php';
    //$html = file_get_html($url);
    //$url = 'http://www.huffingtonpost.com/';
    function img_from_url($url, $html) {
        if ($html->find('img')) {
            foreach ($html->find('img') as $element) {
                /* $raw = ranger($element->src);
                  $im = @imagecreatefromstring($raw);
                  $width = @imagesx($im);
                  $height = @imagesy($im); */
                $array[] = $element->src;
            }
            return $array;
        } else
            return false;
    }

    function img_upload($input_name, $dest) {
        $valid_formats = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
        $basename = basename($_FILES[$input_name]['name']);
        if ($basename == '')
            return '';
        $pathinfo = pathinfo($dest);
        $dir = $pathinfo['dirname'];
        $img_name = $pathinfo['filename'];
        $ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
        //$size = $_FILES[$input_name]['size'];
        //if(strlen($basename)){
        if (in_array($ext, $valid_formats)) {
            //if($size<(512*512)){ // Image size max 262 Ko
            //$actual_image_name = time().$session_id.".".$ext;
            $dest = $dir . '/' . $img_name . '.' . $ext;
            $tmp = $_FILES[$input_name]['tmp_name'];
            if (move_uploaded_file($tmp, $dest)) {
                return $img_name . '.' . $ext;
            }
            //else echo "Erreur téléchargement";
            //}
            //else echo "Fichier image trop grand"; 
        }
        //else echo "Format fichier image invalide"; 
        //}
        return '';
    }

    function img_multiple_upload($input_name, $dest) {
        echo ' img_multiple_upload ';
        /* $nb_img = count($_FILES[$input_name]['name']);
          $out = '';
          for ($i = 0; $i < $nb_img; $i++) {
          $basename = basename($_FILES[$input_name]['name'][$i]);
          if ($basename=='')
          return '';
          $pathinfo = pathinfo($dest);
          $dir = $pathinfo['dirname'];
          $img_name	= $pathinfo['filename'].'_'.$i;
          $ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
          if(move_uploaded_file($_FILES[$input_name]['tmp_name'][$i], $dir.'/'.$img_name.'.'.$ext))
          $out .= '*'.$img_name.'.'.$ext;
          else
          return '';
          }
          echo ' img_multiple_upload end ';
          return substr($out,1); */
    }

    //***************************** Image process ******************

    function img_rename($img_path, $newName) {
        $dir = dirname($img_path);
        $img = basename($img_path);
        list($img_name, $ext) = explode('.', $img);
        rename($img_path, $dir . '/' . $newName . '.' . $ext);
    }

    //***************************** Image convertion ******************

    function img_to_jpg($src) {
        $info = getimagesize($src);
        $quality = 90;

        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($src);
        } elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($src);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($src);
        } else {
            die('Unknown image file format');
        }

        $path = dirname($src);
        $img = basename($src);
        list($img_name, $ext) = explode('.', $img);
        $dest = $path . '/' . $img_name . '.jpg';

        //compress and save file to jpg
        imagejpeg($image, $dest, $quality);

        //return destination file
        return $dest;
    }

    function img_square($src, $dest, $width) {
        $Quality = 90; //jpeg quality
        $out = false;
        if ($dest == NULL)
            $dest = $src;
        $src_pathinfo = pathinfo($src);
        $src_basename = $src_pathinfo['basename'];
        $src_extension = strtolower($src_pathinfo['extension']);
        $dest_extension = strtolower(pathinfo($dest, PATHINFO_EXTENSION));

        list($CurWidth, $CurHeight) = getimagesize($src);
        if ($CurWidth <= 0 || $CurHeight <= 0)
            return false;
        $x_offset = 0;
        $y_offset = 0;
        $ContentWidth = $CurWidth;
        $ContentHeight = $CurHeight;
        $height = $width;
        $rW = $width / $CurWidth;
        $rH = $height / $CurHeight;
        $tempH = $CurHeight * $rW;
        $tempW = $CurWidth * $rH;
        if ($tempH > $height) {
            $y_offset = ($CurHeight - $height / $rW) / 2;
            $ContentHeight = $CurHeight - ($y_offset * 2); //echo '<p>$tempH>$height / '.$y_offset.'</p>';
        } else if ($tempW > $width) {
            $x_offset = ($CurWidth - $width / $rH) / 2;
            $ContentWidth = $CurWidth - ($x_offset * 2); //echo '<p>$tempW>$width / '.$x_offset.'</p>';
        }
        switch ($src_extension) {
            case 'jpg':
            case 'jpeg': $img_rsc = imagecreatefromjpeg($src);
                break;
            case 'gif': $img_rsc = imagecreatefromgif($src);
                break;
            case 'png': $img_rsc = imagecreatefrompng($src);
                break;
            default: return false;
        }
        $NewCanves = imagecreatetruecolor($width, $height);
        imagefill($NewCanves, 0, 0, imagecolorallocate($NewCanves, 255, 255, 255));
        imagealphablending($NewCanves, TRUE);
        if (imagecopyresampled($NewCanves, $img_rsc, 0, 0, $x_offset, $y_offset, $width, $height, $ContentWidth, $ContentHeight)) {
            switch ($dest_extension) {
                case 'jpg':
                case 'jpeg': imagejpeg($NewCanves, $dest, $Quality);
                    break;
                case 'gif': imagegif($NewCanves, $dest);
                    break;
                case 'png': imagepng($NewCanves, $dest);
                    break;
                default: return false;
            }
            $out = $dest;
        }
        imagedestroy($NewCanves);
        return $out;
    }

    function img_resize($src, $dest, $width, $height = 0) {
        $Quality = 90; //jpeg quality
        list($CurWidth, $CurHeight) = getimagesize($src);
        if ($width < $CurWidth) {
            //$dir		= dirname($src);
            $img = basename($src);
            list($img_name, $ext) = explode('.', $img);
            $ext = strtolower($ext);
            switch ($ext) {
                case 'jpg':
                case 'jpeg': $img_res = imagecreatefromjpeg($src);
                    break;
                case 'gif': $img_res = imagecreatefromgif($src);
                    break;
                case 'png': $img_res = imagecreatefrompng($src);
                    break;
                default: return false;
            }

            $height_ = $CurHeight * $width / $CurWidth;
            $width_ = $width;
            if (($height) && ($height < $height_)) {
                $width_ = $width_ * $height / $height_;
                $height_ = $height;
            }
            //$x_offset	= ($CurWidth-$width_)/2;
            //$y_offset	= ($CurHeight-$height_)/2;
            $NewCanves = imagecreatetruecolor($width_, $height_);
            //imagefill($NewCanves, 0, 0, imagecolorallocate($NewCanves, 255, 255, 255));
            //imagealphablending($NewCanves, TRUE);
            if (imagecopyresampled($NewCanves, $img_res, 0, 0, 0, 0, $width_, $height_, $CurWidth, $CurHeight)) {
                switch ($ext) {
                    case 'jpg':
                    case 'jpeg': imagejpeg($NewCanves, $dest, $Quality);
                        break;
                    case 'gif': imagegif($NewCanves, $dest);
                        break;
                    case 'png': imagepng($NewCanves, $dest);
                        break;
                    default: return false;
                }
                if (is_resource($NewCanves)) {
                    imagedestroy($NewCanves);
                }
                return $dest;
            }
            return false;
        } else {
            copy($src, $dest);
            return $dest;
        }
    }
    
}
