<?php
/*
 * create_thumbnail
 * create thumbnail 300 x 300 save to folder /img/tn/
 *******************************************************/
 //TODO: change file name of all files and put them on a counter so there are no duplicate names
function create_thumbnail($original_file, $filename){
    // figure dimensions
    list($width, $height) = getimagesize($original_file);
    if($width > $height){
        $small = $height;
    } else{
        $small = $width;
    }
    $src_w = $src_h = $small;
    $src_x = ($width - $src_w) / 2;
    $src_y = ($height - $src_h) / 2;

    // resize image
    $src_image = imagecreatefromjpeg($original_file);
    $dst = imagecreatetruecolor(300, 300);
    imagecopyresampled($dst, $src_image, 0, 0, $src_x, $src_y, 300, 300, $src_w, $src_h);

    // save thumbnail in 'img/tn/' directory
    $thumbnail_path = 'img/tn/' . $filename;
    $check = imagejpeg($dst, $thumbnail_path);
    if($check){
        $msg = 'Thumbnail was created and saved';
    } else {
        $msg = 'Thumbnail could not be created';
    }
    // free up memory
    imagedestroy($dst);

    return $msg;
}