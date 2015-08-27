<?php
	include ('pixel.php');
	include ('clustering.php');
	$src = "1.jpg";
	$image = imagecreatefromjpeg($src);
		
	for ($x=0; $x<imagesx($image); $x++) {
		for ($y=0; $y<imagesy($image); $y++) {
			$col = imagecolorat($image,$x,$y);
			$pixels[] = toRGBArray($col);
		}
	}
	$newImage = imagecreatetruecolor(imagesx($image),imagesy($image));
	$cluster = new Clustering($pixels,2);
	unset($pixels);
	$x=0; $y=0;
	for ($i=0; $i<sizeof($cluster->objects); $i++,$y++) {
		if ($y == imagesy($newImage)) {
			$y=0;
			$x++;
		}
		$color = $cluster->clusterPoints[$cluster->clusterSet[$i]];
		imagesetpixel($newImage,$x,$y,imagecolorclosest($newImage,$color[0],$color[1],$color[2]));
	}	
	imagejpeg($newImage,"copy.jpg");	
?>
<img src="<?php echo $src ?>"><br><br><br>
<img src="copy.jpg"/>