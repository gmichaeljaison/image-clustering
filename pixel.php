<?php

class Pixel {
	var $red;
	var $green;
	var $blue;
	var $rgbArray;
	
	function Pixel ($rgbValue,$red=null,$green=null,$blue=null) {
		$this->red = $red;
		$this->green = $green;
		$this->blue = $blue;
		$this->rgbArray = array ($red,$green,$blue);
	}
	static function toRGBArray ($rgbValue) {
		$this->red = (int) ($rgbValue/65536);
		$rgbValue -= (int) ($this->red*65536);
		$this->green = (int) ($rgbValue/256);
		$rgbValue -= (int) ($this->green*256);
		$this->blue = $rgbValue;
		return array($this->red,$this->green,$this->bllue);
	}
	static function getRGBValue($red, $green, $blue) {
		return ( ($red*65536) + ($green*256) + $blue );
	}
}
function toRGBArray ($rgbValue) {
	$red = ($rgbValue >> 16) & 0xFF;
	$green = ($rgbValue >> 8) & 0xFF;
	$blue = $rgbValue & 0xFF;
	/*$red = (int) ($rgbValue/65536);
	$rgbValue -= (int) ($red*65536);
	$green = (int) ($rgbValue/256);
	$rgbValue -= (int) ($green*256);
	$blue = $rgbValue;*/
	return array($red,$green,$blue);
}
function getRGBValue($red, $green, $blue) {
	return ( round(($red*65536) + ($green*256) + $blue ));
}

?>