<?php

/**
* Gimpa : gnu image manipulate Apache
* Author: 
* AuthorLink: http://.ir
*/
ini_set('memory_limit', '-1');
function gnt_wrt_optimizer($input, $output, $width) {
    $thumb_width = $width;
    if (preg_match("/\.(png)$/", $input)) {
        $image_full = imagecreatefrompng($input);
    } else {
        $image_full = imagecreatefromjpeg($input);
    }
    $image_full_width = imagesx($image_full);
    $image_full_height = imagesy($image_full);
    $ratio = $image_full_width / $image_full_height;
    $thumb_height = $thumb_width / $ratio;
    $image_thumb = imagecreatetruecolor($thumb_width, $thumb_height);

    if (preg_match("/\.(png)$/", $input)) {
        imagesavealpha($image_thumb, true);
        $transparent = imagecolorallocatealpha($image_thumb, 255, 255, 255, 127);
        imagefill($image_thumb, 0, 0, $transparent);
    }

    imagecopyresampled($image_thumb, $image_full, 0, 0, 0, 0, $thumb_width, $thumb_height, $image_full_width, $image_full_height);

    if (preg_match("/\.(png)$/", $input)) {
        $result_jpg = imagepng($image_thumb, $output);
    } else {
        $result_jpg = imagejpeg($image_thumb, $output,75);
    }

    if ($result_jpg) {
        fwrite(STDOUT,"thumnail created with jpg format\n");
    } else {
        fwrite(STDOUT,"!error with creating jpg thumbnail\n");
    }
}

function gnt_hrt_optimizer($input, $output, $height) {
    $thumb_height = $height;
    if (preg_match("/\.(png)$/", $input)) {
        $image_full = imagecreatefrompng($input);
    } else {
        $image_full = imagecreatefromjpeg($input);
    }
    $image_full_width = imagesx($image_full);
    $image_full_height = imagesy($image_full);
    $ratio = $image_full_width / $image_full_height;
    $thumb_width = $thumb_height * $ratio;
    $image_thumb = imagecreatetruecolor($thumb_width, $thumb_height);

    if (preg_match("/\.(png)$/", $input)) {
        imagesavealpha($image_thumb, true);
        $transparent = imagecolorallocatealpha($image_thumb, 255, 255, 255, 127);
        imagefill($image_thumb, 0, 0, $transparent);
    }

    imagecopyresampled($image_thumb, $image_full, 0, 0, 0, 0, $thumb_width, $thumb_height, $image_full_width, $image_full_height);
    if (preg_match("/\.(png)$/", $input)) {
        $result_jpg = imagepng($image_thumb, $output);
    } else {
        $result_jpg = imagejpeg($image_thumb, $output,75);
    }
    if ($result_jpg) {
        fwrite(STDOUT,"thumnail created with jpg format\n");
    } else {
        fwrite(STDOUT,"!error with creating jpg thumbnail\n");
    }
}

ini_set('memory_limit', '-1');
$i = 1;
$inputGallery_array = glob("inputGallery/*");
foreach ($inputGallery_array as $filename) {
    if (preg_match("/\.(png)$/", $filename)) {
        $tmp_image = imagecreatefrompng($filename);
    } else {
        $tmp_image = imagecreatefromjpeg($filename);
    }
    $tmp_image_width = imagesx($tmp_image);
    $tmp_image_height = imagesy($tmp_image);
    $tmp_image_ratio = $tmp_image_width / $tmp_image_height;
    if ($tmp_image_ratio > 1) {
        $input = $filename;
        $sitename = str_replace("inputGallery/", "", $filename);
        $sitename = str_replace(".jpg", "", strtolower($sitename));
        $sitename = str_replace(".jpeg", "", strtolower($sitename));
        $sitename = str_replace(".png", "", strtolower($sitename));
        if (preg_match("/\.(png)$/", $input)) {
//            $output = "outputGallery/{$sitename}.png";   #save with filename for png
            $output = "outputGallery/{$sitename}.png";  #save with suffix and filename for png
        } else {
//            $output = "outputGallery/{$sitename}.jpg";   #save with filename for jpg
            $output = "outputGallery/{$sitename}.jpg";  #save with suffix and filename for jpg
        }
        $width = 1200;
//        $width = $tmp_image_width;  #save with file width
        if($width > $tmp_image_width){
            $width = $tmp_image_width;  #save with static width
        }
        
        gnt_wrt_optimizer($filename, $output, $width);
        $i++;
    } else {
        $input = $filename;
        $sitename = str_replace("inputGallery/", "", $filename);
        $sitename = str_replace(".jpg", "", strtolower($sitename));
        $sitename = str_replace(".jpeg", "", strtolower($sitename));
        $sitename = str_replace(".png", "", strtolower($sitename));
        if (preg_match("/\.(png)$/", $input)) {
//            $output = "outputGallery/{$sitename}.png";   #save with filename for png
            $output = "outputGallery/{$sitename}.png";  #save with suffix and filename for png
        } else {
//            $output = "outputGallery/{$sitename}.jpg";  #save with filename for jpg
            $output = "outputGallery/{$sitename}.jpg";  #save with suffix and filename for jpg
        }
//        $height = $tmp_image_height;  #save with file height
        $height = 850;  #save with static height
        if($height > $tmp_image_height){
            $height = $tmp_image_height;
        }
        gnt_hrt_optimizer($filename, $output, $height);
        $i++;
    }
}
