<?php

declare(strict_types=1);

namespace App;

use Exception;

use function PhpWeb\app;
use function PhpWeb\base_url;

if(!function_exists('App\asset')){
    function asset(string $file): string
    {
        return base_url('assets/' . $file);
    }
}
if (!function_exists('App\base64_photo')) {
    function base64_photo(?string $fileName = null): string
    {
        if (empty($fileName)) {
            $fileName = 'nophoto.png';
        }

        $allow = ['jpg', 'png', 'jpeg'];  // allowed extensions
        $file = file_photo($fileName);
        $img = file_get_contents($file);
        $file_info = pathinfo($file);

        // if allowed extension
        if (in_array($file_info['extension'], $allow)) {
            // Format the image SRC:  data:{mime};base64,{img_data_base64};
            $src = 'data:image/' . $file_info['extension'] . ';base64,' . base64_encode($img);

            return $src;
        } else {
            throw new Exception('Ivalid file image extension.');
        }
    }
}

if (!function_exists('App\save_base64_photo')) {
    function save_base64_photo(string $data): ?string
    {
        if (empty($data)) {
            return null;
        }

        if (preg_match("/^data:image\/(?<extension>(?:png|jpg|jpeg));base64,(?<image>.+)$/", $data, $matchings)) {
            $imageData = base64_decode($matchings['image']);
            $extension = $matchings['extension'];
            $filename = sprintf('%s.%s', uniqid('photo_'), $extension);

            // resize image
            $im = imagecreatefromstring($imageData);
            $source_width = imagesx($im);
            $source_height = imagesy($im);
            $ratio =  $source_height / $source_width;

            $new_width = 360; // assign new width to new resized image
            $new_height = intval($ratio * 360);

            $thumb = imagecreatetruecolor($new_width, $new_height);

            $transparency = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
            imagefilledrectangle($thumb, 0, 0, $new_width, $new_height, $transparency);

            imagecopyresampled($thumb, $im, 0, 0, 0, 0, $new_width, $new_height, $source_width, $source_height);
            
            if($extension === 'png'){
                imagepng($thumb, file_photo($filename), 8);
            }else{
                imagejpeg($thumb, file_photo($filename), 8);
            }
            
            imagedestroy($im);

            return $filename;

            // without resize image
            //if (file_put_contents(file_photo($filename), $imageData)) {
            //    return $filename;
            //}
        }

        return null;
    }
}


if(!function_exists('App\kepuasan')){
    function kepuasan(string $hasil): string
    {
        switch($hasil){
            case '1':
                return 'Tidak Puas';
                break;
            case '2':
                return 'Kurang Puas';
                break;
            case '3':
                return 'Cukup Puas';
            break;
            case '4':
                return 'Sangat Puas';
                break;
            default:
                return '';
        }
    }
}
if (!function_exists('App\remote_photo')) {
    function remote_photo(string $file): string
    {
        return base_url('uploads/photos/' . $file);
    }
}

if (!function_exists('App\file_photo')) {
    function file_photo(string $file): string
    {
        return ROOT . '/public/uploads/photos/' . $file;
    }
}