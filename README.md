# imageProcessor
php based image processing class to use after uploading image file.It is based on class of codeigniter framework libaray.Some additional feature are added and change the coding style.

Type of process for image.
* resize
* crop
* cropResize (new)
* rotate
* flip
* black and white (new)
* watermark

---
image_lib class should be loaded before using these method.
eg: include("Image_lib.php");
This file has a line "$image = new Image_lib();".
#####It will create a $image instant object.If you don't want , you can remove it.
---
##initial step
Firstly you need to set image to edit on $image object.
$image->setImage('your-image.jpg');
Then you can do the process mentioned above.

##Final step
After image process, you need to save the image.
There are two method to save the image( save and saveAs )
save() method will save you image with same name.
save("new-name.jpg") will save the image with the name you give.
saveAs("new-name.jpg") will create a new image with the given name. 

##Resize
Image can be resize by using resize method
Example:
$image->setImage('your-image.jpg');		
$image->resize(200,200);
$image->saveAs("new-one.jpg");

above code will create a new image and it is resized to 200x200.
if the original image's ratio is not same as your resize ratio, it will make image shrinked.
to prevent this use maintainRatio() method.

$image->setImage('test-image.jpg');		
$image->maintainRatio()->resize(200,200);
$image->saveAs("one.jpg");

with maintain ratio option, your image will be within the required size (200x200)
eg: 200x150 , 100x200 , 145x200
it is within the requred size, size is not exactly same as what we want.
to make it 200x200 from 200x150, we can fill the space with a color.

$image->setImage('your-image.jpg');		
$image->fillExtraSpace("#FFFFFF")->resize(200,200);
$image->saveAs("new-one.jpg");

fillExtraSpace method can make your image with size (200x200) and it fill the space with given color(#FFFFFF).

##Crop
You can crop down the image with crop() method.
Example:
$image->setImage('your-image.jpg');		
$image->crop(200,200);
$image->save();

by running above code, your image will be croped with 200x200 size from the left-top corner.
if you want to move the crop start point,you can use x_axis and y_axis.

$x_axis = 300;
$y_axis = 300;
$image->setImage('your-image.jpg');		
$image->crop(200,200,$x_axis,$y_axis);
$image->save();

##Crop Resize
if you wan to use thumbnail with 200x200 but the original size is 400x500. Then resize can not make perfect image as size ratio are different. you can use cropResize() method.
It will first crop the image to get the same size ratio and then make resize.
Example:
$image->setImage('your-image.jpg');		
$image->cropResize(200,200);
$image->save();

##Rotate
You can easily rotate an image with rotate method.
you can rotate 90,180 or 270 degree.
Example:
$image->setImage('your-image.jpg');		
$image->roate(180);
$image->save();

##Flip
You can flip an image with rotate method.
For horizontal flip, use horizontalFlip method
Example:
$image->setImage('your-image.jpg');		
$image->horizontalFlip();
$image->save();
For vertical flip, use verticalFlip method
Example:
$image->setImage('your-image.jpg');		
$image->verticalFlip();
$image->save();

##Black and White
For Black and white image, use blankNwhite() method
Example:
$image->setImage('your-image.jpg');		
$image->blackNwhite();
$image->save();

##WaterMarking
###1.WaterMarking with text
Example:
$image->setImage('your-image.jpg');		
$image->withText('watermark text here',5,"FFF")->watermark();
$image->save();

above example will create watermarked image with your given text.
####syntax of withText method
withText($you_text,$font_size,$font_color);
for font size you can use 1-5.
if you want to set more wider range of font size,you need to use fontImport method and you will need a font file (eg. arial.ttf ).

Example:
$image->setImage('your-image.jpg');		
$image->fontImport("fonts/arial.ttf")->withText('watermark text here',5,"#FFF")->watermark();
$image->save();

To use text shadow,textShadow method can be used
####syntax of textShadow method
textShadow($shadow_color,$shadow_distance_in_pixel);

$image->setImage('your-image.jpg');		
$image->fontImport("fonts/arial.ttf");
$image->textShadow("#FFF",2)->withText('watermark text here',5,"FFF")->watermark();
$image->save();

###2.WaterMarking with Image
If you want to use image as watermark,it is easily can be done by using withImage method
####syntax of withImage method
withImage($overlay_image_path,$opacity_of_watermarked_image);
opacity can be set between 1-100 and default value is 50.

Example:
$image->setImage('your-image.jpg');		
$image->withImage('overlay.jpg')->watermark();
$image->save();

### Positioning and Aligning watermark.
alignment of watermark
####syntax of alignment method
alignment($horizontal_alignment,$vertical_alignment);
horizontal alignment values = left, center or right
vertical alignment values = top, middle or bottom

Example:
$image->setImage('your-image.jpg');		
$image->alignment('center','center')->withImage('overlay.jpg')->watermark();
$image->save();

Positioning of watermark
alignment can be used easliy to move watermark but it can not move exactly to a point.
position method can move watermark base on alignment position.
####syntax of position method
position($x_position_offset,$y_position_offset);
position($padding);

Example:
$image->setImage('your-image.jpg');		
$image->alignment('left','top')->position(20)->withImage('overlay.jpg')->watermark();
$image->save();

$image->setImage('your-image.jpg');		
$image->alignment('left','top')->position(0,200)->withImage('overlay.jpg')->watermark();
$image->save();


