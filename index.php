<?php
	include("Image_lib.php");

	$config['image_library'] = 'gd2';
	$config['source_image'] = 'test-image.jpg';
	$config['create_thumb'] = TRUE;
	$config['maintain_ratio'] = TRUE;
	$config['width']         = 75;
	$config['height']       = 50;

	$imageProcessor->initialize($config);
?>