<?php
	include("Image_lib.php");
	//watermark
	$image->setImage('test-image.jpg');		
	$image->alignment('left','top')->position(0,200)->withImage('overlay.jpg')->watermark();
	$image->save();
	
	//crop resize
	// $image->setImage('test-image.jpg');
	// $image->verticalFlip();
	// $image->fillExtraSpace("#FF0000")->cropResize(300,300);	
	// $image->saveAs('test-medium.jpg');

	//flip and resize
	// $image->setImage('test-image.jpg');
	// $image->horizontalFlip();
	// $image->resize(500,500);
	// $image->saveAs('test-large.jpg');


	
	
	
?>