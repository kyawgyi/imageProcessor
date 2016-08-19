<?php
/**
* This is a copy of class from codeigniter framewor
* I modify it that it can be use in pure PHP project.
 */


/**
 * Image Manipulation class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Image_lib
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/image_lib.html
 */
class Image_lib {

	/**
	 * PHP extension/library to use for image manipulation
	 * Can be: imagemagick, netpbm, gd, gd2
	 *
	 * @var string
	 */
	public $image_library		= 'gd2';

	/**
	 * Path to the graphic library (if applicable)
	 *
	 * @var string
	 */
	public $library_path		= '';

	/**
	 * Whether to send to browser or write to disk
	 *
	 * @var bool
	 */
	public $dynamic_output		= FALSE;

	/**
	 * Path to original image
	 *
	 * @var string
	 */
	public $source_image		= '';

	/**
	 * Path to the modified image
	 *
	 * @var string
	 */
	public $new_image		= '';

	/**
	 * Image width
	 *
	 * @var int
	 */
	public $width			= '';

	/**
	 * Image height
	 *
	 * @var int
	 */
	public $height			= '';

	/**
	 * Quality percentage of new image
	 *
	 * @var int
	 */
	public $quality			= 90;

	/**
	 * Whether to create a thumbnail
	 *
	 * @var bool
	 */
	public $create_thumb		= FALSE;

	/**
	 * String to add to thumbnail version of image
	 *
	 * @var string
	 */
	public $thumb_marker		= '_thumb';

	/**
	 * Whether to maintain aspect ratio when resizing or use hard values
	 *
	 * @var bool
	 */
	public $maintain_ratio		= FALSE;

	/**
	 * auto, height, or width.  Determines what to use as the master dimension
	 *
	 * @var string
	 */
	public $master_dim		= 'auto';

	/**
	 * Angle at to rotate image
	 *
	 * @var string
	 */
	public $rotation_angle		= '';

	/**
	 * X Coordinate for manipulation of the current image
	 *
	 * @var int
	 */
	public $x_axis			= '';

	/**
	 * Y Coordinate for manipulation of the current image
	 *
	 * @var int
	 */
	public $y_axis			= '';

	// --------------------------------------------------------------------------
	// Watermark Vars
	// --------------------------------------------------------------------------

	/**
	 * Watermark text if graphic is not used
	 *
	 * @var string
	 */
	public $wm_text			= '';

	/**
	 * Type of watermarking.  Options:  text/overlay
	 *
	 * @var string
	 */
	public $wm_type			= 'text';

	/**
	 * Default transparency for watermark
	 *
	 * @var int
	 */
	public $wm_x_transp		= 4;

	/**
	 * Default transparency for watermark
	 *
	 * @var int
	 */
	public $wm_y_transp		= 4;

	/**
	 * Watermark image path
	 *
	 * @var string
	 */
	public $wm_overlay_path		= '';

	/**
	 * TT font
	 *
	 * @var string
	 */
	public $wm_font_path		= '';

	/**
	 * Font size (different versions of GD will either use points or pixels)
	 *
	 * @var int
	 */
	public $wm_font_size		= 17;

	/**
	 * Vertical alignment:   T M B
	 *
	 * @var string
	 */
	public $wm_vrt_alignment	= 'B';

	/**
	 * Horizontal alignment: L R C
	 *
	 * @var string
	 */
	public $wm_hor_alignment	= 'C';

	/**
	 * Padding around text
	 *
	 * @var int
	 */
	public $wm_padding			= 0;

	/**
	 * Lets you push text to the right
	 *
	 * @var int
	 */
	public $wm_hor_offset		= 0;

	/**
	 * Lets you push text down
	 *
	 * @var int
	 */
	public $wm_vrt_offset		= 0;

	/**
	 * Text color
	 *
	 * @var string
	 */
	protected $wm_font_color	= '#ffffff';

	/**
	 * Dropshadow color
	 *
	 * @var string
	 */
	protected $wm_shadow_color	= '';

	/**
	 * Dropshadow distance
	 *
	 * @var int
	 */
	public $wm_shadow_distance	= 2;

	/**
	 * Image opacity: 1 - 100  Only works with image
	 *
	 * @var int
	 */
	public $wm_opacity		= 50;

	// --------------------------------------------------------------------------
	// Private Vars
	// --------------------------------------------------------------------------

	/**
	 * Source image folder
	 *
	 * @var string
	 */
	public $source_folder		= '';

	/**
	 * Destination image folder
	 *
	 * @var string
	 */
	public $dest_folder		= '';

	/**
	 * Image mime-type
	 *
	 * @var string
	 */
	public $mime_type		= '';

	/**
	 * Original image width
	 *
	 * @var int
	 */
	public $orig_width		= '';

	/**
	 * Original image height
	 *
	 * @var int
	 */
	public $orig_height		= '';

	/**
	 * Image format
	 *
	 * @var string
	 */
	public $image_type		= '';

	/**
	 * Size of current image
	 *
	 * @var string
	 */
	public $size_str		= '';

	/**
	 * Full path to source image
	 *
	 * @var string
	 */
	public $full_src_path		= '';

	/**
	 * Full path to destination image
	 *
	 * @var string
	 */
	public $full_dst_path		= '';

	/**
	 * File permissions
	 *
	 * @var	int
	 */
	public $file_permissions = 0644;

	/**
	 * Name of function to create image
	 *
	 * @var string
	 */
	public $create_fnc		= 'imagecreatetruecolor';

	/**
	 * Name of function to copy image
	 *
	 * @var string
	 */
	public $copy_fnc		= 'imagecopyresampled';

	/**
	 * Error messages
	 *
	 * @var array
	 */
	public $error_msg		= array();

	/**
	 * Whether to have a drop shadow on watermark
	 *
	 * @var bool
	 */
	protected $wm_use_drop_shadow	= FALSE;

	/**
	 * Whether to use truetype fonts
	 *
	 * @var bool
	 */
	public $wm_use_truetype	= FALSE;

	public $fill_extra_space = FALSE;

	public $fill_color = array(255,255,255);

	private $req_width;

	private $req_height;

	private $config;

	private $image_obj;

	/**
	 * Initialize Image Library
	 *
	 * @param	array	$props
	 * @return	void
	 */
	public function __construct($props = array())
	{
		if (count($props) > 0)
		{
			$this->initialize($props);
		}

	}

	// --------------------------------------------------------------------

	/**
	 * Initialize image properties
	 *
	 * Resets values in case this class is used in a loop
	 *
	 * @return	void
	 */
	public function clear()
	{		
		$props = array('thumb_marker', 'library_path', 'source_image', 'new_image', 'width', 'height', 'rotation_angle', 'x_axis', 'y_axis', 'wm_text', 'wm_overlay_path', 'wm_font_path', 'wm_shadow_color', 'source_folder', 'dest_folder', 'mime_type', 'orig_width', 'orig_height', 'image_type', 'size_str', 'full_src_path', 'full_dst_path');
		
		if(empty($this->image_obj))
		foreach ($props as $val)
		{
			$this->$val = '';
		}

		$this->image_library 		= 'gd2';
		$this->dynamic_output 		= FALSE;
		$this->quality 				= 90;
		$this->create_thumb 		= FALSE;
		$this->thumb_marker 		= '_thumb';
		$this->maintain_ratio 		= FALSE;
		$this->master_dim 			= 'auto';
		$this->wm_type 				= 'text';
		$this->wm_x_transp 			= 4;
		$this->wm_y_transp 			= 4;
		$this->wm_font_size 		= 17;
		$this->wm_vrt_alignment 	= 'B';
		$this->wm_hor_alignment 	= 'C';
		$this->wm_padding 			= 0;
		$this->wm_hor_offset 		= 0;
		$this->wm_vrt_offset 		= 0;
		$this->wm_font_color		= '#ffffff';
		$this->wm_shadow_distance 	= 2;
		$this->wm_opacity 			= 50;
		$this->create_fnc 			= 'imagecreatetruecolor';
		$this->copy_fnc 			= 'imagecopyresampled';
		$this->error_msg 			= array();
		$this->wm_use_drop_shadow 	= FALSE;
		$this->wm_use_truetype 		= FALSE;
		$this->fill_extra_space     = FALSE;
		$this->fill_color			= array();
	}

	// --------------------------------------------------------------------

	/**
	 * initialize image preferences
	 *
	 * @param	array
	 * @return	bool
	 */
	public function initialize($props = array())
	{
		// Convert array elements into class variables
		if (count($props) > 0)
		{
			foreach ($props as $key => $val)
			{
				if (property_exists($this, $key))
				{
					if (in_array($key, array('wm_font_color', 'wm_shadow_color')))
					{
						if (preg_match('/^#?([0-9a-f]{3}|[0-9a-f]{6})$/i', $val, $matches))
						{
							/* $matches[1] contains our hex color value, but it might be
							 * both in the full 6-length format or the shortened 3-length
							 * value.
							 * We'll later need the full version, so we keep it if it's
							 * already there and if not - we'll convert to it. We can
							 * access string characters by their index as in an array,
							 * so we'll do that and use concatenation to form the final
							 * value:
							 */
							$val = (strlen($matches[1]) === 6)
								? '#'.$matches[1]
								: '#'.$matches[1][0].$matches[1][0].$matches[1][1].$matches[1][1].$matches[1][2].$matches[1][2];
						}
						else
						{
							continue;
						}
					}
					
					$this->$key = $val;
				}
			}
		}

		if($this->fill_extra_space == TRUE)
		{
			$this->maintain_ratio = TRUE;
			$this->req_width = $this->width;
			$this->req_height = $this->height;
		}

		// Is there a source image? If not, there's no reason to continue
		if ($this->source_image === '')
		{
			$this->set_error('imglib_source_image_required');
			return FALSE;
		}

		/* Is getimagesize() available?
		 *
		 * We use it to determine the image properties (width/height).
		 * Note: We need to figure out how to determine image
		 * properties using ImageMagick and NetPBM
		 */
		if ( ! function_exists('getimagesize'))
		{
			$this->set_error('imglib_gd_required_for_props');
			return FALSE;
		}

		$this->image_library = strtolower($this->image_library);

		/* Set the full server path
		 *
		 * The source image may or may not contain a path.
		 * Either way, we'll try use realpath to generate the
		 * full server path in order to more reliably read it.
		 */
		
		if (($full_source_path = realpath($this->source_image)) !== FALSE)
		{
			$full_source_path = str_replace('\\', '/', $full_source_path);
		}
		else
		{
			$full_source_path = $this->source_image;
		}

		$x = explode('/', $full_source_path);
		$this->source_image = end($x);
		$this->source_folder = str_replace($this->source_image, '', $full_source_path);
		
		// Set the Image Properties
		if(empty($this->image_obj))
		{
			if ( ! $this->get_image_properties($this->source_folder.$this->source_image))
			{
				return FALSE;
			}
		}
		
		
		/*
		 * Assign the "new" image name/path
		 *
		 * If the user has set a "new_image" name it means
		 * we are making a copy of the source image. If not
		 * it means we are altering the original. We'll
		 * set the destination filename and path accordingly.
		 */
			$this->setDestinations();


		/* Compile the finalized filenames/paths
		 *
		 * We'll create two master strings containing the
		 * full server path to the source image and the
		 * full server path to the destination image.
		 * We'll also split the destination image name
		 * so we can insert the thumbnail marker if needed.
		 */
		

		/* Should we maintain image proportions?
		 *
		 * When creating thumbs or copies, the target width/height
		 * might not be in correct proportion with the source
		 * image's width/height. We'll recalculate it here.
		 */
		if ($this->maintain_ratio === TRUE && ($this->width !== 0 OR $this->height !== 0))
		{
			$this->image_reproportion();
		}
		
		/* Was a width and height specified?
		 *
		 * If the destination width/height was not submitted we
		 * will use the values from the actual file
		 */
		if ($this->width === '')
		{
			$this->width = $this->orig_width;
		}

		if ($this->height === '')
		{
			$this->height = $this->orig_height;
		}

		// Set the quality
		$this->quality = trim(str_replace('%', '', $this->quality));

		if ($this->quality === '' OR $this->quality === 0 OR ! ctype_digit($this->quality))
		{
			$this->quality = 90;
		}

		// Set the x/y coordinates
		is_numeric($this->x_axis) OR $this->x_axis = 0;
		is_numeric($this->y_axis) OR $this->y_axis = 0;

		// Watermark-related Stuff...
		if ($this->wm_overlay_path !== '')
		{
			$this->wm_overlay_path = str_replace('\\', '/', realpath($this->wm_overlay_path));
		}

		if ($this->wm_shadow_color !== '')
		{
			$this->wm_use_drop_shadow = TRUE;
		}
		elseif ($this->wm_use_drop_shadow === TRUE && $this->wm_shadow_color === '')
		{
			$this->wm_use_drop_shadow = FALSE;
		}

		if ($this->wm_font_path !== '')
		{
			$this->wm_use_truetype = TRUE;
		}

		return $this;
	}

	private function setDestinations()
	{
		if ($this->new_image === '')
		{
			$this->dest_image = $this->source_image;
			$this->dest_folder = $this->source_folder;
		}
		elseif (strpos($this->new_image, '/') === FALSE)
		{			
			$this->dest_folder = $this->source_folder;
			$this->dest_image = $this->new_image;
		}
		else
		{

			if (strpos($this->new_image, '/') === FALSE && strpos($this->new_image, '\\') === FALSE)
			{
				$full_dest_path = str_replace('\\', '/', realpath($this->new_image));
			}
			else
			{
				$full_dest_path = $this->new_image;
			}

			// Is there a file name?
			if ( ! preg_match('#\.(jpg|jpeg|gif|png)$#i', $full_dest_path))
			{
				$this->dest_folder = $full_dest_path.'/';
				$this->dest_image = $this->source_image;
			}
			else
			{
				$x = explode('/', $full_dest_path);
				$this->dest_image = end($x);
				$this->dest_folder = str_replace($this->dest_image, '', $full_dest_path);
			}
		}

		if ($this->create_thumb === FALSE OR $this->thumb_marker === '')
		{
			$this->thumb_marker = '';
		}

		$xp = $this->explode_name($this->dest_image);

		$filename = $xp['name'];
		$file_ext = $xp['ext'];

		$this->full_src_path = $this->source_folder.$this->source_image;
		$this->full_dst_path = $this->dest_folder.$filename.$this->thumb_marker.$file_ext;
	}


	public function setImageLibrary($name,$path)
	{
		$this->config['image_library'] = $name;
		$this->config['library_path']  = $path;
	}

	private function resetConfig()
	{
		
		if(empty($this->config['new_image']))
		{
			$source = $this->config['source_image'];
			$this->config = [];
			$this->config['source_image']= $source;
		}else
		{
			$this->config = [];
		}
	}

	
	// --------------------------------------------------------------------

	public function cropResize($width,$height)
	{	
		if(isset($this->config['maintain_ratio']) && isset($this->config['maintain_ratio']))
		echo "<p class='warning'>maintainRatio method do not have effect on cropResize process.</p>";
	
		if(empty($this->config['source_image']) || !file_exists($this->config['source_image']))
		throw new Exception('Source Image is not set or not found.use setImage()');
		if(!empty($width))
		$this->config['width'] = $width;
		if(!empty($height))
		$this->config['height'] = $height;

		$this->maintain_ratio = FALSE;
		$this->config['maintain_ratio']=FALSE;

		$this->clear();
		$this->initialize($this->config);

		

		$orgImage = $this->get_image_properties($this->source_folder.$this->source_image,true);
		$org_width = $orgImage['width'];
		$org_height = $orgImage['height'];
		$req_width = $this->width;
		$req_height = $this->height;

		$x_axis = 0;
		$y_axis = 0;

		$OR = $org_width/$org_height;
		$RR = $req_width/$req_height;
		if($OR != $RR)
		{
			if($OR < $RR)
			{				
				//base on width			
				$virtual_height = floor($org_width / $req_width * $req_height);
				$virtual_width = floor($org_width);
				$y_axis = ($org_height-$virtual_height)/2;
			}
			elseif($OR > $RR)
			{
				//base on height					
				$virtual_height = floor($org_height);
				$virtual_width = floor($org_height / $req_height * $req_width);
				$x_axis = ($org_width-$virtual_width)/2;
			}	

			$fill_extra_space = $this->fill_extra_space;
			$fill_color = $this->fill_color;

			$this->crop($virtual_width,$virtual_height,$x_axis,$y_axis);
		}
		//if save as new image, crop will creaet a new image 
		//$this->config['source_image'] = $source_image;
		$this->config['fill_extra_space'] = $fill_extra_space;
		$this->config['fill_color'] = $fill_color;
		

		$this->resize($width,$height);

		
		
		$this->resetConfig();
	}

	// --------------------------------------------------------------------

	public function setImage($image)
	{
		$this->config['source_image'] = $image;
	}

	public function maintainRatio()
	{
		$this->config['maintain_ratio'] = true;
		return $this;
	}

	public function fillExtraSpace($hexa_color)
	{
		if(strlen($hexa_color) != 7)
		throw new Exception('Color value pass to fillExtraSpace function format is not valid.eg:#FFFFFF');
		$hexa_color = str_replace("#","", $hexa_color);
		$red   = hexdec($hexa_color[0]. $hexa_color[1]);
		$green = hexdec($hexa_color[2]. $hexa_color[3]);
		$blue  = hexdec($hexa_color[4]. $hexa_color[5]);
		$this->config['fill_color'] = array($red,$green,$blue);
		$this->config['fill_extra_space'] = true;
		return $this;
	}

	public function baseOn($para="auto")
	{		
		$this->config['master_dim']=$para;
		return $this;
	}

	public function blackNwhite()
	{
		$this->clear();
		$this->initialize($this->config);

		if(empty($this->image_obj))
		$this->image_obj = $this->image_create_gd();

		if(!($this->image_obj && imagefilter($this->image_obj, IMG_FILTER_GRAYSCALE)))		
		{		    
		    throw new Exception('Conversion to grayscale failed.');
		}

		$this->resetConfig();
	}


	public function saveAs($newImage)
	{		
		$this->new_image = $newImage;
		$this->setDestinations();
		if(!$this->image_save_gd($this->image_obj))
		{
			throw new Exception('image saving process fail');
		}
		imagedestroy($this->image_obj);
		$this->clear();
		$this->config=[];
		$this->image_obj = null;

	}

	public function save($newName="")
	{
		if(!$this->image_save_gd($this->image_obj))
		{
			throw new Exception('image saving process fail');
		}
		imagedestroy($this->image_obj);

		chmod($this->full_dst_path, $this->file_permissions);

		if($newName)
		rename($this->source_folder.$this->source_image,$this->source_folder.$newName);

		$this->clear();
		$this->config=[];		
		$this->image_obj = null;
	}


	/**
	 * Image Resize
	 *
	 * This is a wrapper function that chooses the proper
	 * resize function based on the protocol specified
	 *
	 * @return	bool
	 */
	public function resize($width,$height)
	{	
		if(isset($this->config['fill_extra_space']) && $this->config['fill_extra_space'] && isset($this->config['master_dim']))
		echo "<p class='warning'> fillExtraSpace method and baseOn method should not be used together</p>";
		
		if(empty($this->config['source_image']) || !file_exists($this->config['source_image']))
		throw new Exception('Source Image is not set or not found.use setImage()');
		if(!empty($width))
		$this->config['width'] = $width;
		if(!empty($height))
		$this->config['height'] = $height;

		$this->clear();
		$this->initialize($this->config);

		$protocol = ($this->image_library === 'gd2') ? 'image_process_gd' : 'image_process_'.$this->image_library;
		
		if(!$this->$protocol('resize'))
		throw new Exception('Resizing Fail');

		$this->resetConfig();
		
	}

	// --------------------------------------------------------------------

	/**
	 * Image Crop
	 *
	 * This is a wrapper function that chooses the proper
	 * cropping function based on the protocol specified
	 *
	 * @return	bool
	 */
	public function crop($width,$height,$x_start=0,$y_start=0)
	{	
		
		if(empty($this->config['source_image']) || !file_exists($this->config['source_image']))
		throw new Exception('Source Image is not set or not found.use setImage()');
		if(!empty($width))
		$this->config['width'] = $width;
		if(!empty($height))
		$this->config['height'] = $height;

		$this->config['x_axis'] = $x_start;
		$this->config['y_axis'] = $y_start;

		$this->clear();
		$this->initialize($this->config);

		$protocol = ($this->image_library === 'gd2') ? 'image_process_gd' : 'image_process_'.$this->image_library;
		
		if(!$this->$protocol('crop'))
		throw new Exception('Cropping Fail');

		

		$this->resetConfig();
	}

	// --------------------------------------------------------------------

	public function verticalFlip()
	{
		return $this->rotate('vrt');
	}

	public function horizontalFlip()
	{
		return $this->rotate('hor');
	}


	/**
	 * Image Rotate
	 *
	 * This is a wrapper function that chooses the proper
	 * rotation function based on the protocol specified
	 *
	 * @return	bool
	 */
	public function rotate($degree)
	{
		
		if(empty($this->config['source_image']) || !file_exists($this->config['source_image']))
		throw new Exception('Source Image is not set or not found.use setImage()');
		
		$this->config['rotation_angle'] = $degree;		
		$this->clear();
		$this->initialize($this->config);

		// Allowed rotation values
		$degs = array(90, 180, 270, 'vrt', 'hor');

		if ($this->rotation_angle === '' OR ! in_array($this->rotation_angle, $degs))
		{
			$this->set_error('imglib_rotation_angle_required');
			return FALSE;
		}

		// Reassign the width and height
		if ($this->rotation_angle === 90 OR $this->rotation_angle === 270)
		{
			$this->width	= $this->orig_height;
			$this->height	= $this->orig_width;
		}
		else
		{
			$this->width	= $this->orig_width;
			$this->height	= $this->orig_height;
		}

		// Choose resizing function
		if ($this->image_library === 'imagemagick' OR $this->image_library === 'netpbm')
		{
			$protocol = 'image_process_'.$this->image_library;
			return $this->$protocol('rotate');
		}

		$status = ($this->rotation_angle === 'hor' OR $this->rotation_angle === 'vrt')
			? $this->image_mirror_gd()
			: $this->image_rotate_gd();

		if(!$status)
		throw new Exception('Rotating Image Fail');

		

		$this->resetConfig();
	}

	// --------------------------------------------------------------------

	/**
	 * Image Process Using GD/GD2
	 *
	 * This function will resize or crop
	 *
	 * @param	string
	 * @return	bool
	 */
	public function image_process_gd($action = 'resize')
	{
		$v2_override = FALSE;
		// If the target width/height match the source, AND if the new file name is not equal to the old file name
		// we'll simply make a copy of the original with the new name... assuming dynamic rendering is off.
		if ($this->dynamic_output === FALSE && $this->orig_width === $this->width && $this->orig_height === $this->height)
		{
			if ($this->source_image !== $this->new_image && @copy($this->full_src_path, $this->full_dst_path))
			{
				chmod($this->full_dst_path, $this->file_permissions);
			}

			return TRUE;
		}

		// Let's set up our values based on the action
		if ($action === 'crop')
		{
			// Reassign the source width/height if cropping			
			$this->orig_width  = $this->width;
			$this->orig_height = $this->height;

			// GD 2.0 has a cropping bug so we'll test for it
			if ($this->gd_version() !== FALSE)
			{
				$gd_version = str_replace('0', '', $this->gd_version());
				$v2_override = ($gd_version == 2);
			}
		}
		else
		{
			// If resizing the x/y axis must be zero
			$this->x_axis = 0;
			$this->y_axis = 0;
		}

		// Create the image handle
		if(empty($this->image_obj))
		{			
			if ( ! ($src_img = $this->image_create_gd()))
			{
				return FALSE;
			}
		}else
		$src_img = $this->image_obj;
		/* Create the image
		 *
		 * Old conditional which users report cause problems with shared GD libs who report themselves as "2.0 or greater"
		 * it appears that this is no longer the issue that it was in 2004, so we've removed it, retaining it in the comment
		 * below should that ever prove inaccurate.
		 *
		 * if ($this->image_library === 'gd2' && function_exists('imagecreatetruecolor') && $v2_override === FALSE)
		 */
		if ($this->image_library === 'gd2' && function_exists('imagecreatetruecolor'))
		{
			$create	= 'imagecreatetruecolor';
			$copy	= 'imagecopyresampled';
		}
		else
		{
			$create	= 'imagecreate';
			$copy	= 'imagecopyresized';
		}

		$x_offset = 0;
		$y_offset = 0;

		if($this->fill_extra_space == true && $action !== 'crop')
		{
			$dst_img = $create($this->req_width, $this->req_height);
			if($this->width < $this->req_width)
			{
				$x_offset = ($this->req_width - $this->width)/2;
			}
			if($this->height < $this->req_height)
			{				
				$y_offset = ($this->req_height - $this->height)/2;
			}
		}
		else
		$dst_img = $create($this->width, $this->height);

		if ($this->image_type === 3) // png we can actually preserve transparency
		{
			imagealphablending($dst_img, FALSE);
			imagesavealpha($dst_img, TRUE);
		}

		if($this->fill_extra_space)
		{
			$color = imagecolorallocate($dst_img, $this->fill_color[0], $this->fill_color[1], $this->fill_color[2]);
			imagefill($dst_img, 0, 0, $color);
		}
		

		$copy($dst_img, $src_img, $x_offset, $y_offset, $this->x_axis, $this->y_axis, $this->width, $this->height, $this->orig_width, $this->orig_height);

		// Show the image
		if ($this->dynamic_output === TRUE)
		{
			$this->image_display_gd($dst_img);
		}
		// elseif ( ! $this->image_save_gd($dst_img)) // Or save it
		// {
		// 	return FALSE;
		// }
		
		$this->image_obj = $dst_img;
		$this->orig_width = $this->width;
		$this->orig_height = $this->height;
		// Kill the file handles
		imagedestroy($src_img);

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Image Process Using ImageMagick
	 *
	 * This function will resize, crop or rotate
	 *
	 * @param	string
	 * @return	bool
	 */
	public function image_process_imagemagick($action = 'resize')
	{
		// Do we have a vaild library path?
		if ($this->library_path === '')
		{
			$this->set_error('imglib_libpath_invalid');
			return FALSE;
		}

		if ( ! preg_match('/convert$/i', $this->library_path))
		{
			$this->library_path = rtrim($this->library_path, '/').'/convert';
		}

		// Execute the command
		$cmd = $this->library_path.' -quality '.$this->quality;

		if ($action === 'crop')
		{
			$cmd .= ' -crop '.$this->width.'x'.$this->height.'+'.$this->x_axis.'+'.$this->y_axis.' "'.$this->full_src_path.'" "'.$this->full_dst_path .'" 2>&1';
		}
		elseif ($action === 'rotate')
		{
			$angle = ($this->rotation_angle === 'hor' OR $this->rotation_angle === 'vrt')
					? '-flop' : '-rotate '.$this->rotation_angle;

			$cmd .= ' '.$angle.' "'.$this->full_src_path.'" "'.$this->full_dst_path.'" 2>&1';
		}
		else // Resize
		{
			if($this->maintain_ratio === TRUE)
			{
				$cmd .= ' -resize '.$this->width.'x'.$this->height.' "'.$this->full_src_path.'" "'.$this->full_dst_path.'" 2>&1';
			}
			else
			{
				$cmd .= ' -resize '.$this->width.'x'.$this->height.'\! "'.$this->full_src_path.'" "'.$this->full_dst_path.'" 2>&1';
			}
		}

		$retval = 1;
		// exec() might be disabled
		if (function_usable('exec'))
		{
			@exec($cmd, $output, $retval);
		}

		// Did it work?
		if ($retval > 0)
		{
			$this->set_error('imglib_image_process_failed');
			return FALSE;
		}

		chmod($this->full_dst_path, $this->file_permissions);

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Image Process Using NetPBM
	 *
	 * This function will resize, crop or rotate
	 *
	 * @param	string
	 * @return	bool
	 */
	public function image_process_netpbm($action = 'resize')
	{
		if ($this->library_path === '')
		{
			$this->set_error('imglib_libpath_invalid');
			return FALSE;
		}

		// Build the resizing command
		switch ($this->image_type)
		{
			case 1 :
				$cmd_in		= 'giftopnm';
				$cmd_out	= 'ppmtogif';
				break;
			case 2 :
				$cmd_in		= 'jpegtopnm';
				$cmd_out	= 'ppmtojpeg';
				break;
			case 3 :
				$cmd_in		= 'pngtopnm';
				$cmd_out	= 'ppmtopng';
				break;
		}

		if ($action === 'crop')
		{
			$cmd_inner = 'pnmcut -left '.$this->x_axis.' -top '.$this->y_axis.' -width '.$this->width.' -height '.$this->height;
		}
		elseif ($action === 'rotate')
		{
			switch ($this->rotation_angle)
			{
				case 90:	$angle = 'r270';
					break;
				case 180:	$angle = 'r180';
					break;
				case 270:	$angle = 'r90';
					break;
				case 'vrt':	$angle = 'tb';
					break;
				case 'hor':	$angle = 'lr';
					break;
			}

			$cmd_inner = 'pnmflip -'.$angle.' ';
		}
		else // Resize
		{
			$cmd_inner = 'pnmscale -xysize '.$this->width.' '.$this->height;
		}

		$cmd = $this->library_path.$cmd_in.' '.$this->full_src_path.' | '.$cmd_inner.' | '.$cmd_out.' > '.$this->dest_folder.'netpbm.tmp';

		$retval = 1;
		// exec() might be disabled
		if (function_usable('exec'))
		{
			@exec($cmd, $output, $retval);
		}

		// Did it work?
		if ($retval > 0)
		{
			$this->set_error('imglib_image_process_failed');
			return FALSE;
		}

		// With NetPBM we have to create a temporary image.
		// If you try manipulating the original it fails so
		// we have to rename the temp file.
		copy($this->dest_folder.'netpbm.tmp', $this->full_dst_path);
		unlink($this->dest_folder.'netpbm.tmp');
		chmod($this->full_dst_path, $this->file_permissions);

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Image Rotate Using GD
	 *
	 * @return	bool
	 */
	public function image_rotate_gd()
	{
		// Create the image handle
		if(empty($this->image_obj))
		{
			if ( ! ($src_img = $this->image_create_gd()))
			{
				return FALSE;
			}
		}else
		$src_img = $this->image_obj;	

		// Set the background color
		// This won't work with transparent PNG files so we are
		// going to have to figure out how to determine the color
		// of the alpha channel in a future release.

		$white = imagecolorallocate($src_img, 255, 255, 255);

		// Rotate it!
		$dst_img = imagerotate($src_img, $this->rotation_angle, $white);

		// Show the image
		if ($this->dynamic_output === TRUE)
		{
			$this->image_display_gd($dst_img);
		}
		// elseif ( ! $this->image_save_gd($dst_img)) // ... or save it
		// {
		// 	return FALSE;
		// }

		$this->image_obj= $dst_img;

		chmod($this->full_dst_path, $this->file_permissions);

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Create Mirror Image using GD
	 *
	 * This function will flip horizontal or vertical
	 *
	 * @return	bool
	 */
	public function image_mirror_gd()
	{
		if(empty($this->image_obj))
		{
			if ( ! ($src_img = $this->image_create_gd()))
			{
				return FALSE;
			}
		}else
		$src_img = $this->image_obj;	

		$width  = $this->orig_width;
		$height = $this->orig_height;

		if ($this->rotation_angle === 'hor')
		{
			for ($i = 0; $i < $height; $i++)
			{
				$left = 0;
				$right = $width - 1;

				while ($left < $right)
				{
					$cl = imagecolorat($src_img, $left, $i);
					$cr = imagecolorat($src_img, $right, $i);

					imagesetpixel($src_img, $left, $i, $cr);
					imagesetpixel($src_img, $right, $i, $cl);

					$left++;
					$right--;
				}
			}
		}
		else
		{
			for ($i = 0; $i < $width; $i++)
			{
				$top = 0;
				$bottom = $height - 1;

				while ($top < $bottom)
				{
					$ct = imagecolorat($src_img, $i, $top);
					$cb = imagecolorat($src_img, $i, $bottom);

					imagesetpixel($src_img, $i, $top, $cb);
					imagesetpixel($src_img, $i, $bottom, $ct);

					$top++;
					$bottom--;
				}
			}
		}

		// Show the image
		if ($this->dynamic_output === TRUE)
		{
			$this->image_display_gd($src_img);
		}
		// elseif ( ! $this->image_save_gd($src_img)) // ... or save it
		// {
		// 	return FALSE;
		// }

		$this->image_obj= $src_img;

		chmod($this->full_dst_path, $this->file_permissions);

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Image Watermark
	 *
	 * This is a wrapper function that chooses the type
	 * of watermarking based on the specified preference.
	 *
	 * @return	bool
	 */
	
	public function withText($text,$font_size,$color)
	{			
		$this->config['wm_type'] = "text";
		$this->config['wm_font_size']=$font_size;
		$this->config['wm_text']=$text;
		$this->config['wm_font_color']=$color;
		return $this;
	}

	public function fontImport($path)
	{
		$this->config['wm_font_path'] = $path;
		return $this;
	}

	public function textShadow($color,$distance)
	{
		$this->config['wm_shadow_distance']= $distance;
		$this->config['wm_shadow_color'] = $color;
		return $this;
	}

	public function withImage($overlay_image,$opactiy=50)
	{
		$this->config['wm_type'] = "overlay";
		$this->config['wm_overlay_path'] = $overlay_image;
		$this->config['wm_opacity'] = $opactiy;
		return $this;
	}

	public function alignment($horizontal,$vertical)
	{
		if($vertical=="center") $vertical = "middle";
		$this->config['wm_vrt_alignment'] = $vertical;
		$this->config['wm_hor_alignment'] = $horizontal;
		
		return $this;
	}

	public function position($hor_offset,$ver_offset=NULL)
	{
		$this->config['wm_vrt_offset'] = $ver_offset;
		$this->config['wm_hor_offset'] = $hor_offset;
		if($ver_offset == NULL)
		$this->config['wm_padding'] = $hor_offset;
		return $this;
	}

	public function watermark($quality=90)
	{			
		
		if(isset($this->config['wm_font_size']) && $this->config['wm_font_size'] > 5 && !isset($this->config['wm_font_path']))
		echo "<p>If you don't use fontImport method,True Type Font will be used. it can support font size (1-5)</p>";

		$this->config['quality'] = $quality;
		if(empty($this->config['source_image']) || !file_exists($this->config['source_image']))
		throw new Exception('Source Image is not set or not found.use setImage()');
		$this->clear();
		$this->initialize($this->config);
		if(!file_exists($this->wm_overlay_path))
		throw new Exception('watermark image path is invalid');
		return ($this->wm_type === 'overlay') ? $this->overlay_watermark() : $this->text_watermark();
	}

	// --------------------------------------------------------------------

	/**
	 * Watermark - Graphic Version
	 *
	 * @return	bool
	 */
	public function overlay_watermark()
	{
		if ( ! function_exists('imagecolortransparent'))
		{
			$this->set_error('imglib_gd_required');
			return FALSE;
		}

		// Fetch source image properties
		$this->get_image_properties();
		// Fetch watermark image properties
		$props		= $this->get_image_properties($this->wm_overlay_path, TRUE);
		$wm_img_type	= $props['image_type'];
		$wm_width	= $props['width'];
		$wm_height	= $props['height'];

		// Create two image resources
		$wm_img  = $this->image_create_gd($this->wm_overlay_path, $wm_img_type);
		//$src_img = $this->image_create_gd($this->full_src_path);

		if(empty($this->image_obj))
		{
			if ( ! ($src_img = $this->image_create_gd($this->full_src_path)))
			{
				return FALSE;
			}
		}else
		$src_img = $this->image_obj;	

		// Reverse the offset if necessary
		// When the image is positioned at the bottom
		// we don't want the vertical offset to push it
		// further down. We want the reverse, so we'll
		// invert the offset. Same with the horizontal
		// offset when the image is at the right

		$this->wm_vrt_alignment = strtoupper($this->wm_vrt_alignment[0]);
		$this->wm_hor_alignment = strtoupper($this->wm_hor_alignment[0]);

		if ($this->wm_vrt_alignment === 'B')
			$this->wm_vrt_offset = $this->wm_vrt_offset * -1;

		if ($this->wm_hor_alignment === 'R')
			$this->wm_hor_offset = $this->wm_hor_offset * -1;

		// Set the base x and y axis values
		$x_axis = $this->wm_hor_offset + $this->wm_padding;
		$y_axis = $this->wm_vrt_offset + $this->wm_padding;

		// Set the vertical position
		if ($this->wm_vrt_alignment === 'M')
		{
			$y_axis += ($this->orig_height / 2) - ($wm_height / 2);
		}
		elseif ($this->wm_vrt_alignment === 'B')
		{
			$y_axis += $this->orig_height - $wm_height;
		}

		// Set the horizontal position
		if ($this->wm_hor_alignment === 'C')
		{
			$x_axis += ($this->orig_width / 2) - ($wm_width / 2);
		}
		elseif ($this->wm_hor_alignment === 'R')
		{
			$x_axis += $this->orig_width - $wm_width;
		}

		// Build the finalized image
		if ($wm_img_type === 3 && function_exists('imagealphablending'))
		{
			@imagealphablending($src_img, TRUE);
		}

		// Set RGB values for text and shadow
		$rgba = imagecolorat($wm_img, $this->wm_x_transp, $this->wm_y_transp);
		$alpha = ($rgba & 0x7F000000) >> 24;

		// make a best guess as to whether we're dealing with an image with alpha transparency or no/binary transparency
		if ($alpha > 0)
		{
			// copy the image directly, the image's alpha transparency being the sole determinant of blending
			imagecopy($src_img, $wm_img, $x_axis, $y_axis, 0, 0, $wm_width, $wm_height);
		}
		else
		{
			// set our RGB value from above to be transparent and merge the images with the specified opacity
			imagecolortransparent($wm_img, imagecolorat($wm_img, $this->wm_x_transp, $this->wm_y_transp));
			imagecopymerge($src_img, $wm_img, $x_axis, $y_axis, 0, 0, $wm_width, $wm_height, $this->wm_opacity);
		}

		// We can preserve transparency for PNG images
		if ($this->image_type === 3)
		{
			imagealphablending($src_img, FALSE);
			imagesavealpha($src_img, TRUE);
		}

		// Output the image
		if ($this->dynamic_output === TRUE)
		{
			$this->image_display_gd($src_img);
		}
		// elseif ( ! $this->image_save_gd($src_img)) // ... or save it
		// {
		// 	return FALSE;
		// }
		$this->image_obj= $src_img;
		imagedestroy($wm_img);

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Watermark - Text Version
	 *
	 * @return	bool
	 */
	public function text_watermark()
	{
		if(empty($this->image_obj))
		{
			if ( ! ($src_img = $this->image_create_gd()))
			{
				return FALSE;
			}
		}else
		$src_img = $this->image_obj;	

		if ($this->wm_use_truetype === TRUE && ! file_exists($this->wm_font_path))
		{
			$this->set_error('imglib_missing_font');
			return FALSE;
		}

		// Fetch source image properties
		$this->get_image_properties();

		// Reverse the vertical offset
		// When the image is positioned at the bottom
		// we don't want the vertical offset to push it
		// further down. We want the reverse, so we'll
		// invert the offset. Note: The horizontal
		// offset flips itself automatically

		if ($this->wm_vrt_alignment === 'B')
		{
			$this->wm_vrt_offset = $this->wm_vrt_offset * -1;
		}

		if ($this->wm_hor_alignment === 'R')
		{
			$this->wm_hor_offset = $this->wm_hor_offset * -1;
		}

		// Set font width and height
		// These are calculated differently depending on
		// whether we are using the true type font or not
		if ($this->wm_use_truetype === TRUE)
		{
			if (empty($this->wm_font_size))
			{
				$this->wm_font_size = 17;
			}

			if (function_exists('imagettfbbox'))
			{
				$temp = imagettfbbox($this->wm_font_size, 0, $this->wm_font_path, $this->wm_text);
				$temp = $temp[2] - $temp[0];

				$fontwidth = $temp / strlen($this->wm_text);
			}
			else
			{
				$fontwidth = $this->wm_font_size - ($this->wm_font_size / 4);
			}

			$fontheight = $this->wm_font_size;
			$this->wm_vrt_offset += $this->wm_font_size;
		}
		else
		{
			$fontwidth  = imagefontwidth($this->wm_font_size);
			$fontheight = imagefontheight($this->wm_font_size);
		}

		// Set base X and Y axis values
		$x_axis = $this->wm_hor_offset + $this->wm_padding;
		$y_axis = $this->wm_vrt_offset + $this->wm_padding;

		if ($this->wm_use_drop_shadow === FALSE)
		{
			$this->wm_shadow_distance = 0;
		}

		$this->wm_vrt_alignment = strtoupper($this->wm_vrt_alignment[0]);
		$this->wm_hor_alignment = strtoupper($this->wm_hor_alignment[0]);

		// Set vertical alignment
		if ($this->wm_vrt_alignment === 'M')
		{
			$y_axis += ($this->orig_height / 2) + ($fontheight / 2);
		}
		elseif ($this->wm_vrt_alignment === 'B')
		{
			$y_axis += $this->orig_height - $fontheight - $this->wm_shadow_distance - ($fontheight / 2);
		}

		// Set horizontal alignment
		if ($this->wm_hor_alignment === 'R')
		{
			$x_axis += $this->orig_width - ($fontwidth * strlen($this->wm_text)) - $this->wm_shadow_distance;
		}
		elseif ($this->wm_hor_alignment === 'C')
		{
			$x_axis += floor(($this->orig_width - ($fontwidth * strlen($this->wm_text))) / 2);
		}

		if ($this->wm_use_drop_shadow)
		{
			// Offset from text
			$x_shad = $x_axis + $this->wm_shadow_distance;
			$y_shad = $y_axis + $this->wm_shadow_distance;

			/* Set RGB values for shadow
			 *
			 * First character is #, so we don't really need it.
			 * Get the rest of the string and split it into 2-length
			 * hex values:
			 */
			$drp_color = str_split(substr($this->wm_shadow_color, 1, 6), 2);
			$drp_color = imagecolorclosest($src_img, hexdec($drp_color[0]), hexdec($drp_color[1]), hexdec($drp_color[2]));

			// Add the shadow to the source image
			if ($this->wm_use_truetype)
			{
				imagettftext($src_img, $this->wm_font_size, 0, $x_shad, $y_shad, $drp_color, $this->wm_font_path, $this->wm_text);
			}
			else
			{
				imagestring($src_img, $this->wm_font_size, $x_shad, $y_shad, $this->wm_text, $drp_color);
			}
		}

		/* Set RGB values for text
		 *
		 * First character is #, so we don't really need it.
		 * Get the rest of the string and split it into 2-length
		 * hex values:
		 */
		$txt_color = str_split(substr($this->wm_font_color, 1, 6), 2);
		$txt_color = imagecolorclosest($src_img, hexdec($txt_color[0]), hexdec($txt_color[1]), hexdec($txt_color[2]));

		// Add the text to the source image
		if ($this->wm_use_truetype)
		{
			imagettftext($src_img, $this->wm_font_size, 0, $x_axis, $y_axis, $txt_color, $this->wm_font_path, $this->wm_text);
		}
		else
		{
			imagestring($src_img, $this->wm_font_size, $x_axis, $y_axis, $this->wm_text, $txt_color);
		}

		// We can preserve transparency for PNG images
		if ($this->image_type === 3)
		{
			imagealphablending($src_img, FALSE);
			imagesavealpha($src_img, TRUE);
		}

		// Output the final image
		if ($this->dynamic_output === TRUE)
		{
			$this->image_display_gd($src_img);
		}
		// else
		// {
		// 	$this->image_save_gd($src_img);
		// }
		$this->image_obj= $src_img;

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Create Image - GD
	 *
	 * This simply creates an image resource handle
	 * based on the type of image being processed
	 *
	 * @param	string
	 * @param	string
	 * @return	resource
	 */
	public function image_create_gd($path = '', $image_type = '')
	{

		if ($path === '')
		{
			$path = $this->full_src_path;
		}

		if ($image_type === '')
		{
			$image_type = $this->image_type;
		}
		switch ($image_type)
		{
			case 1:
				if ( ! function_exists('imagecreatefromgif'))
				{
					$this->set_error(array('imglib_unsupported_imagecreate', 'imglib_gif_not_supported'));
					return FALSE;
				}

				return imagecreatefromgif($path);
			case 2:
				if ( ! function_exists('imagecreatefromjpeg'))
				{
					$this->set_error(array('imglib_unsupported_imagecreate', 'imglib_jpg_not_supported'));
					return FALSE;
				}

				return imagecreatefromjpeg($path);
			case 3:
				if ( ! function_exists('imagecreatefrompng'))
				{
					$this->set_error(array('imglib_unsupported_imagecreate', 'imglib_png_not_supported'));
					return FALSE;
				}

				return imagecreatefrompng($path);
			default:
				$this->set_error(array('imglib_unsupported_imagecreate'));
				return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Write image file to disk - GD
	 *
	 * Takes an image resource as input and writes the file
	 * to the specified destination
	 *
	 * @param	resource
	 * @return	bool
	 */
	public function image_save_gd($resource)
	{
		
		switch ($this->image_type)
		{
			case 1:
				if ( ! function_exists('imagegif'))
				{
					$this->set_error(array('imglib_unsupported_imagecreate', 'imglib_gif_not_supported'));
					return FALSE;
				}

				if ( ! @imagegif($resource, $this->full_dst_path))
				{
					$this->set_error('imglib_save_failed');
					return FALSE;
				}
			break;
			case 2:
				if ( ! function_exists('imagejpeg'))
				{
					$this->set_error(array('imglib_unsupported_imagecreate', 'imglib_jpg_not_supported'));
					return FALSE;
				}

				if ( ! @imagejpeg($resource, $this->full_dst_path, $this->quality))
				{
					$this->set_error('imglib_save_failed');
					return FALSE;
				}
			break;
			case 3:
				if ( ! function_exists('imagepng'))
				{
					$this->set_error(array('imglib_unsupported_imagecreate', 'imglib_png_not_supported'));
					return FALSE;
				}

				if ( ! @imagepng($resource, $this->full_dst_path))
				{
					$this->set_error('imglib_save_failed');
					return FALSE;
				}
			break;
			default:
				$this->set_error(array('imglib_unsupported_imagecreate'));
				return FALSE;
			break;
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Dynamically outputs an image
	 *
	 * @param	resource
	 * @return	void
	 */
	public function image_display_gd($resource)
	{
		header('Content-Disposition: filename='.$this->source_image.';');
		header('Content-Type: '.$this->mime_type);
		header('Content-Transfer-Encoding: binary');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');

		switch ($this->image_type)
		{
			case 1	:	imagegif($resource);
				break;
			case 2	:	imagejpeg($resource, NULL, $this->quality);
				break;
			case 3	:	imagepng($resource);
				break;
			default:	echo 'Unable to display the image';
				break;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Re-proportion Image Width/Height
	 *
	 * When creating thumbs, the desired width/height
	 * can end up warping the image due to an incorrect
	 * ratio between the full-sized image and the thumb.
	 *
	 * This function lets us re-proportion the width/height
	 * if users choose to maintain the aspect ratio when resizing.
	 *
	 * @return	void
	 */
	public function image_reproportion()
	{
		if (($this->width === 0 && $this->height === 0) OR $this->orig_width === 0 OR $this->orig_height === 0
			OR ( ! ctype_digit((string) $this->width) && ! ctype_digit((string) $this->height))
			OR ! ctype_digit((string) $this->orig_width) OR ! ctype_digit((string) $this->orig_height))
		{
			return;
		}

		// Sanitize
		$this->width = (int) $this->width;
		$this->height = (int) $this->height;

		if ($this->master_dim !== 'width' && $this->master_dim !== 'height')
		{
			if ($this->width > 0 && $this->height > 0)
			{
				$this->master_dim = ((($this->orig_height/$this->orig_width) - ($this->height/$this->width)) < 0)
							? 'width' : 'height';
			}
			else
			{
				$this->master_dim = ($this->height === 0) ? 'width' : 'height';
			}
		}
		elseif (($this->master_dim === 'width' && $this->width === 0)
			OR ($this->master_dim === 'height' && $this->height === 0))
		{
			return;
		}

		if ($this->master_dim === 'width')
		{
			$this->height = (int) ceil($this->width*$this->orig_height/$this->orig_width);
		}
		else
		{
			$this->width = (int) ceil($this->orig_width*$this->height/$this->orig_height);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get image properties
	 *
	 * A helper function that gets info about the file
	 *
	 * @param	string
	 * @param	bool
	 * @return	mixed
	 */
	public function get_image_properties($path = '', $return = FALSE)
	{
		// For now we require GD but we should
		// find a way to determine this using IM or NetPBM

		if ($path === '')
		{
			$path = $this->full_src_path;
		}

		if ( ! file_exists($path))
		{
			$this->set_error('imglib_invalid_path');
			return FALSE;
		}

		$vals = getimagesize($path);
		$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');
		$mime = (isset($types[$vals[2]])) ? 'image/'.$types[$vals[2]] : 'image/jpg';

		if ($return === TRUE)
		{
			return array(
					'width' =>	$vals[0],
					'height' =>	$vals[1],
					'image_type' =>	$vals[2],
					'size_str' =>	$vals[3],
					'mime_type' =>	$mime
				);
		}

		$this->orig_width	= $vals[0];
		$this->orig_height	= $vals[1];
		$this->image_type	= $vals[2];
		$this->size_str		= $vals[3];
		$this->mime_type	= $mime;

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Size calculator
	 *
	 * This function takes a known width x height and
	 * recalculates it to a new size. Only one
	 * new variable needs to be known
	 *
	 *	$props = array(
	 *			'width'		=> $width,
	 *			'height'	=> $height,
	 *			'new_width'	=> 40,
	 *			'new_height'	=> ''
	 *		);
	 *
	 * @param	array
	 * @return	array
	 */
	private function size_calculator($vals)
	{
		if ( ! is_array($vals))
		{
			return;
		}

		$allowed = array('new_width', 'new_height', 'width', 'height');

		foreach ($allowed as $item)
		{
			if (empty($vals[$item]))
			{
				$vals[$item] = 0;
			}
		}

		if ($vals['width'] === 0 OR $vals['height'] === 0)
		{
			return $vals;
		}

		if ($vals['new_width'] === 0)
		{
			$vals['new_width'] = ceil($vals['width']*$vals['new_height']/$vals['height']);
		}
		elseif ($vals['new_height'] === 0)
		{
			$vals['new_height'] = ceil($vals['new_width']*$vals['height']/$vals['width']);
		}

		return $vals;
	}

	// --------------------------------------------------------------------

	/**
	 * Explode source_image
	 *
	 * This is a helper function that extracts the extension
	 * from the source_image.  This function lets us deal with
	 * source_images with multiple periods, like: my.cool.jpg
	 * It returns an associative array with two elements:
	 * $array['ext']  = '.jpg';
	 * $array['name'] = 'my.cool';
	 *
	 * @param	array
	 * @return	array
	 */
	private function explode_name($source_image)
	{
		$ext = strrchr($source_image, '.');
		$name = ($ext === FALSE) ? $source_image : substr($source_image, 0, -strlen($ext));

		return array('ext' => $ext, 'name' => $name);
	}

	// --------------------------------------------------------------------

	/**
	 * Is GD Installed?
	 *
	 * @return	bool
	 */
	private function gd_loaded()
	{
		if ( ! extension_loaded('gd'))
		{
			/* As it is stated in the PHP manual, dl() is not always available
			 * and even if so - it could generate an E_WARNING message on failure
			 */
			return (function_exists('dl') && @dl('gd.so'));
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Get GD version
	 *
	 * @return	mixed
	 */
	public function gd_version()
	{
		if (function_exists('gd_info'))
		{
			$gd_version = @gd_info();
			return preg_replace('/\D/', '', $gd_version['GD Version']);
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Set error message
	 *
	 * @param	string
	 * @return	void
	 */
	private function set_error($msg)
	{
		if(is_array($msg))
		{
			throw new Exception(implode(" ",$msg));
		}else
		throw new Exception($msg);
	}

	// --------------------------------------------------------------------

	

}

$image = new Image_lib();
