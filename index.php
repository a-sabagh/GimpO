<?php

/**
* Gimpa : gnu image manipulate Apache
* Author: gnutec
* AuthorLink: http://gnutec.ir
*/

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
        $result_jpg = imagejpeg($image_thumb, $output);
    }

    if ($result_jpg) {
        echo "<span style='color: greenyellow;'>thumnail created with jpg format</span><br>";
    } else {
        echo "<span style='color: orangered;'>error with creating jpg thumbnail</span><br>";
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
        $result_jpg = imagejpeg($image_thumb, $output);
    }
    if ($result_jpg) {
        echo "<span style='color: greenyellow;'>thumnail created with jpg format</span><br>";
    } else {
        echo "<span style='color: orangered;'>error with creating jpg thumbnail</span><br>";
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
        $sitename = str_replace(".jpg", "", $sitename);
        $sitename = str_replace(".png", "", $sitename);
        if (preg_match("/\.(png)$/", $input)) {
//            $output = "outputGallery/{$sitename}.png";  #save for png with filename
            $output = "outputGallery/gnutec{$sitename}.png";  #save with suffix and filename
        } else {
//            $output = "outputGallery/{$sitename}.jpg";
            $output = "outputGallery/gnutec{$sitename}.jpg";
        }

//        $width = $tmp_image_width;
        $width = 1280;
        gnt_wrt_optimizer($input, $output, $width);
        $i++;
    } else {
        $input = $filename;
        $sitename = str_replace("inputGallery/", "", $filename);
        $sitename = str_replace(".jpg", "", $sitename);
        $sitename = str_replace(".png", "", $sitename);
        if (preg_match("/\.(png)$/", $input)) {
//            $output = "outputGallery/{$sitename}.png";  #save for png with filename
            $output = "outputGallery/gnutec{$sitename}.png";
        } else {
//            $output = "outputGallery/{$sitename}.jpg";
            $output = "outputGallery/gnutec{$sitename}.jpg";
        }

//        $height = $tmp_image_height;
        $height = 700;
        gnt_hrt_optimizer($input, $output, $height);
        $i++;
    }
}