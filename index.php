<?php
	include("Image_lib.php");

	$config['source_image'] = 'test-image.jpg';
	$config['width'] = '200';
	$config['height'] = '400';	
	$config['fill_extra_space'] = true;
	$config['fill_color'] = array(255,255,255);

	$imageProcessor->initialize($config);
	
	//$imageProcessor->cropResize();
	
	
?>