<?php
// to take a mirror image of an image
function image_mirror ($input_image_resource)
{
    $width = imagesx ( $input_image_resource );
    $height = imagesy ( $input_image_resource );
    $output_image_resource = imagecreatetruecolor ( $width, $height );
    $y = 1;

    while ( $y < $height )
    {
        for ( $i = 1; $i <= $width; $i++ )
            imagesetpixel ( $output_image_resource, $i, $y, imagecolorat ( $input_image_resource, ( $i ), ( $height - $y ) ) );
        $y = $y + 1;
    }
   
    return $output_image_resource;
}
// to get thumbnail of given size
// with max width or heigth
function resize_image($filename,$width,$height) {
	list($width_orig, $height_orig) = getimagesize($filename);	
	$ratio_orig = $width_orig/$height_orig;	
	if ($width/$height > $ratio_orig) {
	   $width = $height*$ratio_orig;
	} else {
	   $height = $width/$ratio_orig;
	}	
	// Resample
	$image_p = imagecreatetruecolor($width, $height);
	$image = imagecreatefromjpeg($filename);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	return $image_p;
}
// The file
/*
$filename = 'ad.jpg';

// Set a maximum height and width
$width = 200;
$height = 200;

// Content type
header('Content-type: image/jpeg');

// Get new dimensions
list($width_orig, $height_orig) = getimagesize($filename);

$ratio_orig = $width_orig/$height_orig;

if ($width/$height > $ratio_orig) {
   $width = $height*$ratio_orig;
} else {
   $height = $width/$ratio_orig;
}

// Resample
$image_p = imagecreatetruecolor($width, $height);
$image = imagecreatefromjpeg($filename);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

// Output
imagejpeg($image_p, null, 100);*/
?>