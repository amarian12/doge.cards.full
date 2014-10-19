<?php
	unset($_SESSION['canAccess']);
	$link = new mysqli("HOST", "USERNAME", "PASSWORD", "DB");
	$query = "SELECT gckey FROM giftcards WHERE gckey = '" . $_GET['code'] . "' LIMIT 1";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_assoc($result);	
	if($row == NULL)
	{
		echo 'That key does not exist!';
		die();
	}
	mysqli_close($link);
		
	$code = html_entity_decode($_GET['code']).' ' ;
	$style = html_entity_decode($_GET['style']).' ' ;
	$style = str_replace(' ', '', $style);
	
	if(empty($code))
	fatal_error('Error: Text not properly formatted.') ;
	//---- TIME TO DO SOME MAGIC ----
	$font_file      = 'cour.ttf';
	$font_size      = 37 ;
	$font_color     = '#433b16' ;
	$image_file     = 'styles/'.$style.'.png';
	$x_finalpos     = 80; //-174 //258
	$y_finalpos     = 420; //45 //45
	$mime_type          = 'image/png' ;
	$extension          = '.png' ;
	$s_end_buffer_size  = 4096 ;
	
	function hex_to_rgb($color)
	{
		list($r, $g, $b) = array($color[0].$color[1],
								 $color[2].$color[3],
								 $color[4].$color[5]);
		$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
		return array($r, $g, $b);
	}
	
	// check for GD support
	if(!function_exists('ImageCreate'))
		fatal_error('Error: Server does not support PHP image generation') ;
	
	// check font availability;
	if(!is_readable($font_file)) {
		fatal_error('Error: The server is missing the specified font.') ;
	}
	
	// create and measure the text
	$font_rgb = hex_to_rgb($font_color) ;
	$box = @ImageTTFBBox($font_size,0,$font_file,$text) ;
	
	$text_width = abs($box[2]-$box[0]);
	$text_height = abs($box[5]-$box[3]);
	
	$image =  imagecreatefrompng($image_file);
	
	if(!$image || !$box)
	{
		fatal_error('Error: The server could not create this image.') ;
	}
	
	// allocate colors and measure final text position
	$font_color = ImageColorAllocate($image,$font_rgb['red'],$font_rgb['green'],$font_rgb['blue']) ;
	
	$image_width = imagesx($image);
	
	$put_text_x = $image_width - $text_width - ($image_width - $x_finalpos);
	$put_text_y = $y_finalpos;
	
	// Write the text
	imagettftext($image, $font_size, 0, $put_text_x,  $put_text_y, $font_color, $font_file, $code);
	
	
	header('Content-type: ' . $mime_type) ;
	ImagePNG($image) ;
	
	ImageDestroy($image) ;
	exit ;
?>