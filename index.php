<?php
	include ('pixel.php');
	include ('clustering.php');
	include ('image.php');
	
	$src = empty($_GET['img'])?"1.jpg":$_GET['img'];
	$width = empty($_GET['w'])?250:$_GET['w'];
	$height = empty($_GET['h'])?250:$_GET['h'];
	$nClusters = empty($_GET['clusters'])?2:$_GET['clusters'];
	$image = resize_image($src,$width,$height);
		
	for ($x=0; $x<imagesx($image); $x++) {
		for ($y=0; $y<imagesy($image); $y++) {
			$col = imagecolorat($image,$x,$y);
			$pixels[] = toRGBArray($col);
		}
	}
	$newImage = imagecreatetruecolor(imagesx($image),imagesy($image));
	$cluster = new Clustering($pixels,$nClusters);
//	print_r($cluster->clusterPoints);
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
<img src="<?php echo $src; ?>" style="max-width:<?php echo $width; ?>px; max-height:<?php echo $height; ?>px;"><br />
  <br />
  <br />
  <img src="copy.jpg"/>
</p>
