<?php
/*
Plugin Name: TTFTitles
Plugin URI: http://www.templature.com/2007/10/18/ttftitles-wordpress-plugin/
Description: This plugin provides two new template tags to replace plain text with styled images.  This is primarily a reworking of the Image Headlines plugin. Of course, THAT was a reworking of another plugin by Joel Bennett.  The main changes over Brian's plugin are (a) a richer admin interface, (b) the ability to predefine multiple image text styles, and (c) using template tags instead of depending on arguments to the_title. Anything that works really well probably came from Brian's code. Anything screwed up is probably my fault.
Version: 0.4.2
Author: John Leavitt
Author URI: http://www.jrrl.com
*/


// For backward compatibility

if (!defined('PLUGINDIR')) {
  define('PLUGINDIR', 'wp-content/themes/babysweettooth'); // no leading slash, no trailing slash
}




// =================================================================
// DEFINES, DEFAULTS, AND SETTINGS 
//
//

define(TTFTITLES_VERSION, '0.1.6');
define(TTFTITLES_DIRECTORY, ABSPATH . 'wp-content/themes/babysweettooth/ttftitles');
define(TTFTITLES_DEBUG, true);

$ttftitles_edit_labels = array ('image_type'           => array('Image Type','enum', 
								array('png' => 'PNG', 'gif' => 'GIF')),
				'font_name'            => array('Font Name','enum', 'ttftitles_get_font_list'),
				'font_size'            => array('Font Size','number'),
				'font_color'           => array('Font Color','text'),
				'letter_case'          => array('Letter Case', text),
				'bg_color'             => array('Background Color','text'),
				'bg_transparent'       => array('Transparent Background','boolean'),
				'bg_image'             => array('Background Image','text'),
				'indent'               => array('Indent','number'),
				'maxwidth'             => array('Max Line Width','number'),
				'subindent'            => array('Sub Indent','number'),
				'leading'              => array('Leading','number'),
				'effect_type'          => array('Effect Type','enum',
								array('soft_shadow' => 'Soft Shadow',
								      'hard_shadow' => 'Hard Shadow',
								      'none' => 'None')),
				'soft_shadow_color'    => array ('Shadow Color', 'text'),
				'soft_shadow_spread'   => array ('Shadow Spread', 'number'),
				'soft_shadow_x_offset' => array ('Shadow X Offset', 'number'),
				'soft_shadow_y_offset' => array ('Shadow Y Offset', 'number'),
				'hard_shadow_color_1'  => array ('First Shadow Color', 'text'),
				'hard_shadow_color_2'  => array ('Second Shadow Color', 'text'),
				'hard_shadow_offset'   => array ('Shadow Offset', 'number'),
				);

$ttftitles_defaults = array('cache_directory' => TTFTITLES_DIRECTORY . '/cache',
			    'cache_url'       => get_option('siteurl') . '/wp-content/themes/babysweettooth/ttftitles/cache',
			    'cache_lifetime'  => 30,
			    'last_cache_tidy' => time(),
			    'font_directory'  => TTFTITLES_DIRECTORY . '/fonts',
			    'default_style'    => 'basic'
			    );

$ttftitles_default_styles = array ('basic' => array ('image_type' => 'png',
						     'font_name' => 'Warp 1',
						     'font_size' => 24,
						     'font_color' => '#990000',
						     'bg_color' => '#FFFFFF',
						     'bg_transparent' => true,
						     'bg_image' => null,
						     'indent' => 0,
						     'maxwidth' => 500,
						     'subindent' => 20,
						     'leading' => 5,
						     'effect_type' => 'soft_shadow',
						     'soft_shadow_x_offset' => 2,
						     'soft_shadow_y_offset' => 2,
						     'soft_shadow_spread' => '4',
						     'soft_shadow_color' => '#000000',
						     ),
				   'demo' => array ('image_type' => 'png',
						    'font_name' => 'Warp 1',
						    'font_size' => 24,
						    'font_color' => '#666666',
						    'bg_color' => '#FFFFFF',
						    'bg_transparent' => true,
						    'bg_image' => null,
						    'indent' => 0,
						    'maxwidth' => 500,
						    'subindent' => 20,
						    'leading' => 5,
						    'effect_type' => 'none'
						    ),
				   'klinkbigpink' => array ('image_type' => 'png',
						    'font_name' => 'KlinkOMite',
						    'font_size' => 24,
						    'font_color' => '#db429a',
						    'bg_color' => '#feeef7',
						    'bg_transparent' => true,
						    'bg_image' => null,
						    'indent' => 0,
						    'maxwidth' => 500,
						    'subindent' => 20,
						    'leading' => 5,
						    'effect_type' => 'none',
							'letter_case' => 'upper'
						    ),
				   'klinkomitepink' => array ('image_type' => 'png',
						    'font_name' => 'KlinkOMite',
						    'font_size' => 19,
						    'font_color' => '#db429a',
						    'bg_color' => '#feeef7',
						    'bg_transparent' => true,
						    'bg_image' => null,
						    'indent' => 0,
						    'maxwidth' => 500,
						    'subindent' => 20,
						    'leading' => 5,
						    'effect_type' => 'none',
							'letter_case' => 'upper'
						    ),						
				   'sweettooth' => array ('image_type' => 'png',
						    'font_name' => 'Spahrty Girl',
						    'font_size' => 55,
						    'font_color' => '#462c10',
						    'bg_color' => '#fed9ee',
						    'bg_transparent' => true,
						    'bg_image' => null,
						    'indent' => 0,
						    'maxwidth' => 500,
						    'subindent' => 20,
						    'leading' => 5,
						    'effect_type' => 'soft_shadow',
							'soft_shadow_color' => '#db429a',
							'soft_shadow_spread' => 4,
							'soft_shadow_x_offset' => 2,
							'soft_shadow_y_offset' => 2
						    )
				   );




// -----------------------------------------------------------------
// ttftitles_complain
//
// emits error messages IFF TTFTITLES_DEBUG is not false

function ttftitles_complain ($complaint) {
  if (TTFTITLES_DEBUG) {
    echo $complaint;
  }
}



// -----------------------------------------------------------------
// ttftitles_get_option
//
// get the settings, even if you have set them first!

function ttftitles_get_option () {
  global $ttftitles_defaults, $ttftitles_default_styles;
  $options = get_option('ttftitles_settings');
  if (!$options) {
    $options = $ttftitles_defaults;
    $options['styles'] = $ttftitles_default_styles;
  }
  update_option ('ttftitles_settings', $options);
  return $options;
}



// -----------------------------------------------------------------
// ttftitles_save_settings
//
// save the settings

function ttftitles_save_settings ($options) {
  ksort ($options);
  update_option ('ttftitles_settings', $options);
  return $options;
}




// =================================================================
// CACHE STUFF
//
// Your basic cache stuff



// -----------------------------------------------------------------
// ttftitles_clear_cache
//
// deletes everything from the cache

function ttftitles_clear_cache ($options=false) {
  if (!$options) {
    $options = ttftitles_get_option();
  }
  $cachedir = $options['cache_directory'];
  if (($dir = @opendir($cachedir)) !== false) {
    while (($file = @readdir($dir)) !== false) {
      $fullname = $cachedir . DIRECTORY_SEPARATOR . $file;
      if (is_file($fullname)) {
	@unlink($fullname);
      }
    }
  }
}



// -----------------------------------------------------------------
// ttftitles_purge_cache
//
// deletes everything more than lifetime days old from the cache

function ttftitles_purge_cache ($options=false) {
  if (!$options) {
    $options = ttftitles_get_option();
  }
  $cachedir = $options['cache_directory'];
  $lifetime = $options['cache_lifetime'];
  if (($dir = @opendir($cachedir)) !== false) {
    while (($file = @readdir($dir)) !== false) {
      $fullname = $cachedir . DIRECTORY_SEPARATOR . $file;
      if (is_file($fullname)) {
	$daysold = (time() - filectime($fullname)) / (24*60*60);
	if ($daysold > $lifetime) {
	  @unlink($fullname);
	}
      }
    }
  }
}



// -----------------------------------------------------------------
// ttftitles_tidy_cache
//
// every twelve hours, purges old files from the cache

function ttftitles_tidy_cache ($options) {
  if ((time()-$options['last_cache_tidy']) > (12*60*60)) {
    ttftitles_purge_cache($options);
    $options['last_cache_tidy'] = time();
    ttftitles_save_settings($options);
  }
}



// -----------------------------------------------------------------
// ttftitles_cache_filename
//
// generates an SEO-friendly filename for the cache

function ttftitles_cache_filename ($text, $style) {
  ksort ($style);
  return (md5($text . ':' . implode(':',array_values($style))));
}




// =================================================================
// FONT FOO
//
// Much of the font reading stuff was taken from the image_headlines 
// plugin by Brian Dupuis.  When that plugin didn't work in 
// WordPress 2.3, I decided to take a swipe at reworking it and
// adding some functionality.
// 
// Function and variable names changed to avoid collision for anyone
// using both plugins.  Also, reformatted the code for my personal
// taste.



// -----------------------------------------------------------------
// ttftitles_readint
//
// reads an integer of length $size from $file at $offset

function ttftitles_readint ($file, $offset, $size) {
  @fseek( $file, $offset, SEEK_SET );
  $string = @fread( $file, $size );
  $myarray = @unpack( (( $size == 2 ) ? 'n' : 'N').'*', $string );
  return intval($myarray[1]);
}



// -----------------------------------------------------------------
// ttftitles_get_ttf_font_name
//
// attempts to find a font name in a ttf file (spoooooky)

function ttftitles_get_ttf_font_name ($fullpath) {

  $return_string = '';
    
  $thefile = @fopen($fullpath, 'rb');
  if ($thefile) {
    // Read the number of records.
    $num_tables = ttftitles_readint( $thefile, 4, 2 );

    // Loop through looking for the name record.
    $offset = 12;
    $name_offset = 0;
    $name_length = 0;
    for( $x = 0; ( $x < $num_tables ) && !feof( $thefile ) && ( $name_offset == 0 ); $x++ ) {
      @fseek( $thefile, $offset, SEEK_SET );
      $tag = @fread( $thefile, 4 );
	
      if( !strcmp( $tag, 'name' ) ) {
	// Found the 'name' tag so read the offset into the file of
	// the name table.
	$offset += 8;
	$name_offset = ttftitles_readint( $thefile, $offset, 4 );
	$name_length = ttftitles_readint( $thefile, $offset+4, 4 );
      } else {
	$offset += 16;
      }	
    }
      
    // See if we have an offset to the name table.
    if( $name_offset != 0 ) {
      // Yay, likely this is a valid TTF file. That's nice. See how many name entries
      // we have.
      $num_names = ttftitles_readint( $thefile, $name_offset+2, 2 );
      $string_storage_offset = ttftitles_readint( $thefile, $name_offset+4, 2 );
      $name_id_offset = $name_offset + 12;
	
      // Let's find the name record that we desire. We're looking for a name ID
      // of 4.
      $name_string_offset = 0;
      $good_count = 0;
      $preferred = 0;
      for ($x = 0; ( $x < $num_names ) && !feof( $thefile ) /*&& ( $name_string_offset == 0 )*/; $x++ ) {
	$name_id = ttftitles_readint( $thefile, $name_id_offset, 2 );
	if( $name_id == 4 ) {
	  $good_names[$good_count]['platform_id'] = ttftitles_readint( $thefile, $name_id_offset-6, 2 );
	  $good_names[$good_count]['encoding_id'] = ttftitles_readint( $thefile, $name_id_offset-4, 2 );
	  $good_names[$good_count]['language_id'] = ttftitles_readint( $thefile, $name_id_offset-2, 2 );
	    
	  // Odd I know... we're searching for a Windows platform string with these
	  // precise parameters. It's the most common among fonts that I've seen. Not that this is a
	  // Unicode string so we'll have to deal with that rather naively below. The problem with
	  // the other formats is that many shareware/freeware fonts -- which a lot of people
	  // will probably use -- is that they're inconsistent with their string settings (like the
	  // bundled font... one of the strings is left at "Arial".
	  if (($good_names[$good_count]['platform_id'] == 3) && 
	      ($good_names[$good_count]['encoding_id'] == 1) && 
	      ($good_names[$good_count]['language_id'] == 1033)) {
	    $preferred = $good_count;
	  }							
	    
	  $good_names[$good_count]['string_length'] = ttftitles_readint( $thefile, $name_id_offset+2, 2 );
	  $good_names[$good_count++]['string_offset'] = ttftitles_readint( $thefile, $name_id_offset+4, 2 );
	}						
	$name_id_offset += 12;
      }
	
      // Did we find one?
      if( $good_count ) {
	// This getting old yet? What a goofy file format, and PHP is far from the most
	// efficient binary file parsers available. Anyway, we apparently have our string.
	// Let's read out the damned thing and have done with it.
	@fseek( $thefile, $name_offset + $string_storage_offset + $good_names[$preferred]['string_offset'], SEEK_SET );
	$return_string = @fread( $thefile, $good_names[$preferred]['string_length'] );
	for( $x = 0; $x < 32; $x++ )
	  $unicode_chars[] = chr($x);
	$return_string = str_replace( $unicode_chars, '', $return_string );
      }
    }
    fclose( $thefile );
  }

  return $return_string;   
}



// -----------------------------------------------------------------
// ttftitles_get_font_list
//
// returns a sorted list of fonts

function ttftitles_get_font_list ($options=null) {
  if (!$options) {
    $options = ttftitles_get_option();
  }
  $fontdir = $options['font_directory'];
  if (($dir = @opendir($fontdir)) !== false) {
    while (($file = @readdir($dir)) !== false) {
      $fullname = $fontdir . DIRECTORY_SEPARATOR . $file;
      $font_name = ttftitles_get_ttf_font_name ($fullname);
      if ($font_name) {
	$result[$font_name] = $fullname;
      }
    }
  }
  closedir ($dir);
  return $result;
}



// -----------------------------------------------------------------
// ttftitles_find_font
//
// 

function ttftitles_find_font ($font_to_find, $options=null) {
  if (!$options) {
    $options = ttftitles_get_option();
  }
  $fontdir = $options['font_directory'];
  if (($dir = @opendir($fontdir)) !== false) {
    while (($file = @readdir($dir)) !== false) {
      $fullname = $fontdir . DIRECTORY_SEPARATOR . $file;
      $font_name = ttftitles_get_ttf_font_name ($fullname);
      if ($font_name == $font_to_find) {
	closedir($dir);
	return $fullname;
      }
    }
  }
}




// =================================================================
// IMAGE FOO
//
// Here's where we actually generate the image... lots of inherited
// code here, although broken up more.  If anything works, it is 
// due to Brian's code.  If anything is broken, it is due to my
// reworking of Brian's code.  Let me know and I'll fix it!.



// -----------------------------------------------------------------
// ttftitles_break_text_into_lines
//
// breaks the text into pieces based on line length and the font

function ttftitles_break_text_into_lines ($text, $style) {
  // the returned array of strings to be on separate lines.
  $text_array = array();
  if ($style['maxwidth'] <= 0) {
    return (array($text));
  }
		
  // Figure out how big a space is. Yes, I'm being anal.
  $bbox = @imagettfbbox($style['font_size'],0,$style['font_file'],' ');
  $space_width = max($bbox[2],$bbox[4]) - min($bbox[0], $bbox[6]);
  
  // Split the array into word components.
  $words = explode(' ',$text);
  $current_line = '';
  $current_width = $current_settings['indent'];
  foreach ($words as $word) {
    $bbox = @imagettfbbox($style['font_size'], 0, $style['font_file'], $word);
    $word_width = max($bbox[2],$bbox[4]) - min($bbox[0], $bbox[6]);
    
    // See if the current word will fit on the line.
    if ($word_width + $current_width + $space_width > $style['maxwidth']) {
      // It won't. Check the border case where we have a friggin'
      // huge first word. If so, it'll have to be rendered on the
      // line regardless.
      if ($current_line != '') {
	$text_array[] = $current_line;
	$current_width = $word_width + $style['indent'] + $style['subindent'];
	$current_line = $word;
      } else {
	$text_array[] = $word;
	$current_width = $style['indent'] + $style['subindent'];
	$current_line = '';
      }
      continue;
    }
    
    // Word fits, so append it.
    if ($current_line != '') {
      $current_line .= ' ';
    }
	
    $current_line .= $word;
    $current_width += $word_width + $space_width;
  }
	
  if ($current_line != '') {
    $text_array[] = $current_line;
  }
  
  return $text_array;
}



// -----------------------------------------------------------------
// ttftitles_hex_to_rgb
//
// your basic hex to rgb converter
// 

function ttftitles_hex_to_rgb ($hex) {
  if (substr($hex,0,1) == '#') { $hex = substr($hex,1); }
    
  if (strlen($hex) == 3) {
    $r = $hex[0] . $hex[0];
    $g = $hex[1] . $hex[1];
    $b = $hex[2] . $hex[2];
  } else {
    $hex .= '000000';
    $r = $hex[0] . $hex[1];
    $g = $hex[2] . $hex[3];
    $b = $hex[4] . $hex[5];
  }
  $rgb['red']   = hexdec($r);
  $rgb['green'] = hexdec($g);
  $rgb['blue']  = hexdec($b);
  return $rgb ;
}   



// -----------------------------------------------------------------
// ttftitles_gaussian_blur
//
// stolen wholesale from ImageHeadline_gaussian
//
// I had hoped to replace this will precalced kernels and calls
// to image_convolution, but image_convolution only does up to a
// 3x3 convolution matrix.  Without that, I decided to be lazy and 
// just use what Brian had used.  That said, if someone has a
// convolution function for gd that allows for NxN kernels, let me
// know and I'll gladly steal that instead.

function ttftitles_gaussian_blur (&$image, $width, $height, $spread) {
  // Check for silly spreads
  if( $spread == 0 )  return;
  if( $spread > 10 )  $spread = 10;
  
  if( strlen( $memory_limit = trim(ini_get('memory_limit' )) ) > 0 ) {
    $last = strtolower($memory_limit{strlen($memory_limit)-1});
    switch($last) {
      // The 'G' modifier is available since PHP 5.1.0
    case 'g':
      $memory_limit *= 1024;
    case 'm':
      $memory_limit *= 1024;
    case 'k':
      $memory_limit *= 1024;
    }
      
    if( $memory_limit <= 32 * 1024 * 1024 ) {
      $use_low_memory_method = true;
    }
  } else {
    $use_low_memory_method = false;
  }


  // Perform gaussian blur convlution. First, prepare the convolution 
  // kernel and precalculated multiplication array. Algorithm
  // adapted from the simply exceptional code by Mario Klingemann
  // <http://incubator.quasimondo.com>. Kernel is essentially an
  // approximation of a gaussian distribution by utilizing squares.
  $kernelsize = $spread*2-1;
  $kernel = array_fill( 0, $kernelsize, 0 );
  $mult = array_fill( 0, $kernelsize, array_fill( 0, 256, 0 ) );
  for( $i = 1; $i < $spread; $i++ ) {
    $smi = $spread - $i;
    $kernel[$smi-1]=$kernel[$spread+$i-1]=$smi*$smi;
    for( $j = 0; $j < 256; $j++ ) {
      $mult[$smi-1][$j] = $mult[$spread+$i-1][$j] = $kernel[$smi-1]*$j;
    }
  }
  $kernel[$spread-1]=$spread*$spread;
  for( $j = 0; $j < 256; $j++ ) {
    $mult[$spread-1][$j] = $kernel[$spread-1]*$j;
  }
  
  if( !$use_low_memory_method ) {
    
    // Kernel and multiplication array calculated, let's get the image
    // read out into a usable format.
    $imagebytes = $width*$height;
    $i = 0;
    for( $x = 0; $x < $width; $x++ ) {
      for( $y = 0; $y < $height; $y++ ) {
	$rgb = imagecolorat( $image, $x, $y );
	$imagearray[$i++] = $rgb;
      }				
    }
  }
  
  // Everything's set. Let's run the first pass. Our first pass will be a 
  // vertical pass.
  for( $x = 0; $x < $width; $x++ ) {
    for( $y = 0; $y < $height; $y++ ) {
      $sum = 0;
      $cr = $cg = $cb = 0;
      for( $j = 0; $j < $kernelsize; $j++ ) {
	$kernely = $y + ( $j - ( $spread - 1 ) );
	if( ( $kernely >= 0 ) && ( $kernely < $height ) ) {
	  if( !$use_low_memory_method ) {
	    $ci = ( $x * $height ) + $kernely;
	    $rgb = $imagearray[$ci];
	  } else {
	    $rgb = imagecolorat( $image, $x, $kernely );
	  }
	  $cr += $mult[$j][($rgb >> 16 ) & 0xFF];
	  $cg += $mult[$j][($rgb >> 8 ) & 0xFF];
	  $cb += $mult[$j][$rgb & 0xFF];
	  $sum += $kernel[$j];
	}
      }
      $ci = ( $x * $height ) + $y;
      $shadowarray[$ci] = ( ( intval(round($cr/$sum)) & 0xff ) << 16 ) | ( ( intval(round($cg/$sum)) & 0xff ) << 8 ) | ( intval(round($cb/$sum)) & 0xff );
    }
  }			
  
  // Free up some memory
  if( isset( $imagearray ) ) {
    unset( $imagearray );
  }
  
  // Now let's make with the horizontal passing. That sentence
  // contruct never gets old: "make with the". Oh the humor.
  for( $x = 0; $x < $width; $x++ ) {
    for( $y = 0; $y < $height; $y++ ) {
      $sum = 0;
      $cr = $cg = $cb = 0;
      for( $j = 0; $j < $kernelsize; $j++ ) {
	$kernelx = $x + ( $j - ( $spread - 1 ) );
	if( ( $kernelx >= 0 ) && ( $kernelx < $width ) ) {
	  $ci = ( $kernelx * $height ) + $y;
	  $cr += $mult[$j][($shadowarray[$ci] >> 16 ) & 0xFF];
	  $cg += $mult[$j][($shadowarray[$ci] >> 8 ) & 0xFF];
	  $cb += $mult[$j][$shadowarray[$ci] & 0xFF];
	  $sum += $kernel[$j];
	}
      }
      $r = intval(round($cr/$sum));
      $g = intval(round($cg/$sum));
      $b = intval(round($cb/$sum));
      
      if( $r < 0 ) $r = 0;
      else if( $r > 255 ) $r = 255;
      if( $g < 0 ) $g = 0;
      else if( $g > 255 ) $g = 255;
      if( $b < 0 ) $b = 0;
      else if( $b > 255 ) $b = 255;
      
      $color = ( $r << 16 ) | ($g << 8 ) | $b;
      
      if( !isset( $colors[ $color ] ) ) {
	$colors[ $color ] = imagecolorallocate( $image, $r, $g, $b );
      }
      
      imagesetpixel( $image, $x, $y, $colors[$color] );
    }
  }
}



function ttftitles_effect_space ($style) {
  // Calculate how much additional space is needed for shadows.
  $effectx = $effecty = 0;
  switch ($style['effect_type']) {
  case 'hard_shadow':
    $effectx = $effecty = $style['hard_shadow_offset'];
    break;
  case 'soft_shadow': 
    $effectx = $style['soft_shadow_spread'] + $style['soft_shadow_x_offset'];
    $effecty = $style['soft_shadow_spread'] + $style['soft_shadow_y_offset'];
    break;
  default:
    break;
  }
  return array($effectx, $effecty);
}



// -----------------------------------------------------------------
// ttftitles_get_image_bbox
//
// calculates the bounding box for the image
// (pulled from/based on ImageHeadline_render)

function ttftitles_get_image_bbox ($lines, $style) {
  $max_y = -1;
  $current_y = -1;
  $bheight = 0;
  $bwidth = 0;

  list ($effectx, $effecty) = ttftitles_effect_space ($style);
  foreach ($lines as $line) {
    $bbox = @imagettfbbox($style['font_size'], 0, $style['font_file'], $line);
    $width = $style['indent'] + $effectx + 2 +
      (max($bbox[0],$bbox[2],$bbox[4],$bbox[6]) - 
       min($bbox[0],$bbox[2],$bbox[4],$bbox[6]));
    $altwidth = $style['indent'] + $effectx + 2 + max($bbox[0],$bbox[2],$bbox[4],$bbox[6]);
    if ($altwidth > $width) { $width = $altwidth; }   /* to handle weird font issues */

    $height = $effecty + (max($bbox[1],$bbox[3],$bbox[5],$bbox[7]) - 
			  min($bbox[1],$bbox[3],$bbox[5],$bbox[7]));
    $altheight = $effecty + (max($bbox[1],$bbox[3],$bbox[5],$bbox[7]));
    if ($altheight > $height) { $height = $altheight; }   /* to handle weird font issues */

    // If this isn't the first line of multi-line text, we have to take into account
    // the space between each line vertically as well any line indent horizontally.
    if ($max_y > 0) {
      $bheight += $style['leading'];
      $width += $style['subindent'];
    }
    if ($height > $max_y) {
      $max_y = $height;
    }
    if ($current_y == -1) {
      $current_y = abs(min($bbox[5], $bbox[7])) - 1;
    }
    
    // Increment height and latch width to the widest line.	
    if ($bwidth < $width ) { $bwidth = $width; }
  }

  $bheight += count( $lines ) * $max_y;
  
  return array($current_y, $max_y, $bheight, $bwidth);
}



// -----------------------------------------------------------------
// ttftitles_add_background_image
//
// if $style includes a background image, this adds it to $image
//
// Based heavily on code pullout out of ImageHeadline_render, 
// but with handling for gif and jpeg backgrounds added.

function ttftitles_add_background_image (&$image, $style, $background_color) {
  $name = $style['bg_image'];
  if (empty($name)) {
    return;
  }
  if (!is_readable($name)) {
    ttftitles_complain ('Could not read image "' . $name . '"');
    return;
  }
  list($widthi, $heighti, $typei, $attri) = getimagesize($name);
  $bgextension = strtolower(preg_replace('/^.*\\./', '', $name));
  switch ($bgextension) {
  case 'jpg':
  case 'jpeg':
  case 'jpe':
    $bgimage = imagecreatefromjpeg ($name);
    break;

  case 'gif':
    $bgimage = imagecreatefromgif ($name);
    break;

  case 'png':
    $bgimage = imagecreatefrompng ($name);
    break;

  default:
  }
  imagecolortransparent($bg,$background_color);
  imagealphablending($bgimage, true);
  imagealphablending($image, true);
  imagesettile($image, $bgimage);
  imagefill($image, 1, 1, IMG_COLOR_TILED);
  return;
}



// -----------------------------------------------------------------
// ttftitles_render
//
// stolen to some degree from ImageHeadline_render

function ttftitles_render ($text, $stylename='', $overrides='') {

  // no text, so we bail...
  if( strlen($text) == 0 ) { return; }

  $retVal = $text;

  $options = ttftitles_get_option();
  if (empty($stylename)) {
    $stylename = $options['default_style'];
  }
  $style = $options['styles'][$stylename];

  // unknown style, so we bail...
  if (!$style) { 
    ttftitles_complain('Could not find style "' . $stylename . '"');
    return $retVal; 
  }

  if ($overrides) {
    $formats = explode( '&', $overrides);
    foreach ($formats as $format ) {
      list($key,$value) = explode( '=', $format, 2 );
      $style[$key]=$value;
    }
  }

  // check image type... 
  // if not png or gif, we bail
  switch (strtoupper($style['image_type'])) {
  case 'PNG':  $extension = '.png';   break;
  case 'GIF':  $extension = '.gif';   break;
  default:
    ttftitles_complain ('Unknown image type: ' . $style['image_type']);
    return $text;
  }

  // handle magic quotes
  if (get_magic_quotes_gpc()) { $text = stripslashes($text); }

  // see if it is already cached...
  ttftitles_tidy_cache($options);
  $filename = ttftitles_cache_filename ($text, $style);
  $cache_filename = $options['cache_directory'] . DIRECTORY_SEPARATOR . $filename . $extension ;
  $generated_url = $options['cache_url'] . DIRECTORY_SEPARATOR . $filename . $extension ;
  if (file_exists($cache_filename)) {
    list($width, $height, $type, $attr) = getimagesize($cache_filename);
    return "<img class=\"ttf\" src=\"$generated_url\" alt=\"" . addslashes($text) . "\" $attr />" ;
  }

  // okay, we need to generate it instead... but only if we can cache it!
  if (!is_writable($options['cache_directory'])) {
    ttftitles_complain ('Cache directory "' . $options['cache_directory'] . '" is not writable.');
    return $text;
  }

  // check font availability
  $style['font_file'] = ttftitles_find_font ($style['font_name']);
  if (!$style['font_file']) {
    ttftitles_complain ('Font "' . $style['font_name'] . '" was not found.');
    return ($text);
  }


  // handle case transform

  switch ($style['letter_case']) {
  case 'upper':
    $text = strtoupper ($text);
    break;
  case 'lower':
    $text = strtolower ($text);
    break;
  case 'capital':
    $text = ucwords ($text);
    break;
  }    

  // figure out some basic image factoids
  $bg_rgb = ttftitles_hex_to_rgb($style['bg_color']);
  $font_rgb = ttftitles_hex_to_rgb($style['font_color']);
  $text_array = ttftitles_break_text_into_lines ($text, $style);
  list($current_y, $max_y, $bheight, $bwidth) = ttftitles_get_image_bbox ($text_array, $style);

  // create the image... or bail if we can't    
  // took out support for indexed pictures because it annoyed me
  $image = @imagecreatetruecolor($bwidth,$bheight);
  if (!$image) {
    ttftitles_complain ('Could not create image.');
    return $text;
  }

  $background_color = @imagecolorallocate($image, $bg_rgb['red'], $bg_rgb['green'], $bg_rgb['blue']) ;
  imagefill($image, 0, 0, $background_color);
  if ($style['bg_transparent']) {
    imagecolortransparent($image,$background_color); 
  }

  // allocate colors and draw text
  $textcolor = @imagecolorallocate($image,$font_rgb['red'], $font_rgb['green'], $font_rgb['blue']); 
    
  // Blit the background image in there. This is always fun. 
  ttftitles_add_background_image ($image, $style, $background_color);
    
  $saved_y = $current_y;

  switch ($style['effect_type']) {

  case 'hard_shadow':
    // "Classic" method of text drawn in two different colors.
    $current_x = 0;
    $shadow_rgb = ttftitles_hex_to_rgb($style['hard_shadow_color_1']);
    $shadow_1 = @imagecolorallocate($image,$shadow_rgb['red'], $shadow_rgb['green'], $shadow_rgb['blue']);
    $shadow_rgb = ttftitles_hex_to_rgb($style['hard_shadow_color_2']);
    $shadow_2 = @imagecolorallocate($image,$shadow_rgb['red'], $shadow_rgb['green'], $shadow_rgb['blue']);
    foreach ($text_array as $line) {
      @imagettftext($image, $style['font_size'], 0, $current_x + $style['indent'] + $style['hard_shadow_offset'] * 2, $current_y + $style['hard_shadow_offset'] * 2, $shadow_2, $style['font_file'], $line);
      @imagettftext($image, $style['font_size'], 0, $current_x + $style['indent'] + $style['hard_shadow_offset'], $current_y + $style['hard_shadow_offset'], $shadow_1, $style['font_file'], $line);
	
	$current_y += $max_y + $style['leading'];
	if ($current_x == 0 ) {
	  $current_x += $style['subindent'];
	}
    }
    break;
    
    
    // SOFT SHADOW
  case 'soft_shadow':
    $current_x = 0;
    $current_y = $saved_y;
    $shadow_image = @imagecreatetruecolor($bwidth, $bheight);
    imagefill ($shadow_image, 0, 0, $background_color);
    $shadow_rgb = ttftitles_hex_to_rgb($style['soft_shadow_color']);
    $shadow_color = @imagecolorallocate($shadow_image, $shadow_rgb['red'], $shadow_rgb['green'], $shadow_rgb['blue']); 
    $current_x = 0;
							
    foreach ($text_array as $line) {
      @imagettftext($shadow_image,  $style['font_size'], 0,
		   $current_x + $style['indent'] + $style['soft_shadow_x_offset'], 
		   $current_y + $style['soft_shadow_y_offset'], 
		   $shadow_color, $style['font_file'], $line);
      $current_y += $max_y + $style['leading'];
      if ($current_x == 0) {
	$current_x += $style['subindent'];
      }
    }
    
    ttftitles_gaussian_blur($shadow_image, $bwidth, $bheight, $style['soft_shadow_spread']);
    if ($style['bg_transparent']) {
      imagecolortransparent($shadow_image,$background_color);
    }
    imagealphablending($shadow_image, true);
    imagecopymerge($image, $shadow_image, 0, 0, 0, 0, $bwidth, $bheight, 50);
    imagedestroy($shadow_image);
    break;

  default:
    
  }


  $current_x = 0;
  $current_y = $saved_y;
  foreach ($text_array as $line) {
    @imagettftext($image,  $style['font_size'], 0, $current_x + $style['indent'], $current_y, $textcolor, $style['font_file'], $line);
    $current_y += $max_y + $style['leading'];
    if ($current_x == 0) {
      $current_x += $style['subindent'];
    }
  }

  switch ($style['image_type']) {
  case 'png':
    @imagepng($image,$cache_filename);
    break;
  case 'gif':
    @imagegif($image,$cache_filename);
    break;
  default:
  }
  imagedestroy($image);

  if (file_exists($cache_filename)) {
    return "<img class=\"ttf\" src=\"$generated_url\" alt=\"" . addslashes($text) . "\" width=\"$bwidth\" height=\"$bheight\" />" ;
  } else {
    ttftitles_complain ("Unknown Error creating file '$cache_filename'.");
    return $text;
  }
}	   




// =================================================================
// THEME STUFF
//
// The actual theme tags

// -----------------------------------------------------------------
// the_ttftitle
//
// replacement for the_title

function the_ttftitle ($before = '', $after = '', $echo = true, $style='', $overrides='') {
	$title = get_the_title();

	$title = ttftitles_render($title, $style, $overrides);
	if (strlen($title) == 0) { return; }

	$title = $before . $title . $after;

	if ($echo) {
	  echo $title;
	} else {
	  return $title;
	}
}



// -----------------------------------------------------------------
// the_ttftext
//
// a more general theme tag for inserting ttf styled text

function the_ttftext ($text, $echo = true, $style='', $overrides='') {
  $ttftext = ttftitles_render($text, $style, $overrides);
  if ($echo) {
    echo $ttftext;
  } else {
    return $ttftext;
  }
}




// =================================================================
// ADMIN FOO
//
//


function ttftitles_create_admin_page () {
  add_submenu_page('themes.php', 'TTFTitles', 'TTF Titles', 10, 'ttftitles', 'ttftitles_admin_page');
}
add_action('admin_menu', 'ttftitles_create_admin_page');

function ttftitles_head_fluff () {
  ?>
<link rel="stylesheet" href="/wp-content/themes/babysweettooth/ttftitles/js/mini_mooRainbow.css" type="text/css" />
<link rel="stylesheet" href="/wp-content/themes/babysweettooth/ttftitles/ttftitles.css" type="text/css" />
<script type="text/javascript" src="/wp-content/themes/babysweettooth/ttftitles/js/mootools-release-1.11.js"></script>
<script type="text/javascript" src="/wp-content/themes/babysweettooth/ttftitles/js/mooRainbow.js"></script>
<script type="text/javascript" src="/wp-content/themes/babysweettooth/ttftitles/js/ttftitles.js"></script>
<?php
    }


//add_action('admin_head', 'ttftitles_head_fluff');
add_action('admin_head-presentation_page_ttftitles', 'ttftitles_head_fluff');

// -----------------------------------------------------------------
// ttfitles_menu
//
// generates the subsubmenu for our little plugin

function ttftitles_menu ($which) {
  $menu = array('Styles' => $_SERVER['PHP_SELF'] . '?page=ttftitles&action=show+styles',
		'Cache'  => $_SERVER['PHP_SELF'] . '?page=ttftitles&action=show+cache',
		'Fonts'  => $_SERVER['PHP_SELF'] . '?page=ttftitles&action=show+fonts',
		'Usage'  => $_SERVER['PHP_SELF'] . '?page=ttftitles&action=show+usage'
);

  echo '<ul id="subsubmenu">';
  foreach ($menu as $label => $url) {
    echo '<li><a href="' . $url . '" ';
    if ($which == $label) {
      echo ' class="current"';
    }
    echo ">$label</a></li>\n";
  }
  echo '</ul>' . "\n";
}



// -----------------------------------------------------------------
// ttftitles_admin_page
//
// the work horse of the display stuff

function ttftitles_admin_page () {
  global $ttftitles_edit_labels, $ttftitles_default_styles;
  $options = ttftitles_get_option();

  // default to the style tab
  $menutab = 'Styles';
  $message = '';

  //exactly what are we looking at/changing
  if ($_REQUEST['action']) {
    switch ($_REQUEST['action']) {


      // USAGE ACTION
    case 'show usage': {
      $menutab = 'Usage';
      break;
    }


      // CACHE ACTIONS

    case 'show cache': {
      $menutab = 'Cache';
      break;
    }
    case 'cache settings':
      $menutab = 'Cache';
      $anything_changed = false;
      if (($_REQUEST['cache_directory']) &&
	  ($options['cache_directory'] != $_REQUEST['cache_directory'])) {
	$options['cache_directory'] = $_REQUEST['cache_directory'];
	$anything_changed = true;
      }
      if (($_REQUEST['cache_url']) &&
	  ($options['cache_url'] != $_REQUEST['cache_url'])) {
	$options['cache_url'] = $_REQUEST['cache_url'];
	$anything_changed = true;
      }
      if (($_REQUEST['cache_lifetime']) &&
	  ($options['cache_lifetime'] != $_REQUEST['cache_lifetime'])) {
	$options['cache_lifetime'] = $_REQUEST['cache_lifetime'];
	$anything_changed = true;
      }
      if ($anything_changed) {
	ttftitles_save_settings($options);
	$message = 'Cache settings updated.';
      }
      break;
    case 'clear cache':
      $menutab = 'Cache';
      ttftitles_clear_cache($options); 
      $message = 'Cache cleared.';
      break;


      // FONT ACTIONS
    case 'font directory': 
      $menutab = 'Fonts';
      if (($_REQUEST['font_directory']) &&
	  ($options['font_directory'] != $_REQUEST['font_directory'])) {
	$options['font_directory'] = $_REQUEST['font_directory'];
	ttftitles_save_settings($options);
	$message = 'Font directory changed.';
      }
      break;
    case 'delete font':
      $menutab = 'Fonts';
      $font_file = ttftitles_find_font ($_REQUEST['font_name'], $options);
      $message = 'Font "' . $_REQUEST['font_name'] . '" deleted.';
      @unlink($font_file);
      break;
    case 'font upload': 
      $menutab = 'Fonts';
      if ($_FILES['font_file']) {
	$success = move_uploaded_file($_FILES['font_file']['tmp_name'], $options['font_directory'] . DIRECTORY_SEPARATOR . $_FILES['font_file']['name']);
	if (!$success) {
	  ttftitles_complain ("Could not move uploaded file.");
	  $message = 'Could not move uploaded file. Sorry.';
	} else {
	  $message = 'New font file "' . $_FILES['font_file']['name'] . '" added.';
	}
      }
      break;
    case 'show fonts': 
      $menutab = 'Fonts';
      break;


      // STYLE ACTIONS
    case 'default style':
      $options['default_style'] = $_REQUEST['style_name'];
      $message = 'Default style changed to "' . $_REQUEST['style_name'] . '".';
      ttftitles_save_settings($options);
    case 'edit style':
    case 'show styles':
      $menutab = 'Styles';
      break;
    case 'delete style':
      $menutab = 'Styles';
      $allstyles = $options['styles'];
      unset($allstyles[$_REQUEST['style_name']]);
      $options['styles'] = $allstyles;

      if (empty($allstyles)) {
	$allstyles = $ttf_default_styles;
	$options['styles'] = $allstyles;
	$options['default_style'] = 'basic';
      } else if ($options['default_style'] == $_REQUEST['style_name']) {
	$keys = array_keys ($allstyles);
	sort ($keys);
	$options['default_style'] = $keys[0];
      }
      $message = 'Style "' . $_REQUEST['style_name'] . '" deleted.';
      ttftitles_save_settings($options);
      break;
    case 'update style':
      $menutab = 'Styles';
      $style = $options['styles'][$_REQUEST['style_name']];
      $style['image_type']     = $_REQUEST['image_type'];
      $style['font_name']      = $_REQUEST['font_name'];
      $style['font_size']      = $_REQUEST['font_size'];
      $style['font_color']     = $_REQUEST['font_color'];
      $style['letter_case']    = $_REQUEST['letter_case'];
      $style['bg_color']       = $_REQUEST['bg_color'];
      $style['bg_transparent'] = $_REQUEST['bg_transparent'];
      $style['bg_image']       = trim($_REQUEST['bg_image']);
      $style['indent']         = $_REQUEST['indent'];
      $style['maxwidth']       = $_REQUEST['maxwidth'];
      $style['subindent']      = $_REQUEST['subindent'];
      $style['leading']        = $_REQUEST['leading'];
      $style['effect_type']    = $_REQUEST['effect_type'];

      unset($style['effect_details']);
      unset($style['effect']);
      switch ($style['effect_type']) {
      case 'none':
	break;
      case 'soft_shadow':
	$style['soft_shadow_color']    = ($_REQUEST['soft_shadow_color'] ? $_REQUEST['soft_shadow_color'] : '#000000');
	$style['soft_shadow_spread']   = $_REQUEST['soft_shadow_spread'];
	$style['soft_shadow_x_offset'] = $_REQUEST['soft_shadow_x_offset'];
	$style['soft_shadow_y_offset'] = $_REQUEST['soft_shadow_y_offset'];
	break;
      case 'hard_shadow':
	$style['hard_shadow_color_1'] = ($_REQUEST['hard_shadow_color_1'] ? $_REQUEST['hard_shadow_color_1'] : '#FFF');
	$style['hard_shadow_color_2'] = ($_REQUEST['hard_shadow_color_2'] ? $_REQUEST['hard_shadow_color_2'] : '#000');
	$style['hard_shadow_offset']  = $_REQUEST['hard_shadow_offset'];
	break;
      }
      $options['styles'][$_REQUEST['style_name']] = $style;
      $message = 'Style "' . $_REQUEST['style_name'] . '" updated.';

      ttftitles_save_settings($options);
      break;

    default:    
    }
  }

  ttftitles_menu ($menutab);
  echo '<div class="wrap">';

  if ($message) {
    echo "<div id=\"message\" class=\"updated fade\"><p>&raquo; $message</p></div>";
  }

  switch ($menutab) {
  case 'Styles':
    $handled = false;
    if ($_REQUEST['action'] == 'edit style') {
      $handled = ttftitles_style_edit_page ($options);
    }
    if (!$handled) {
      ttftitles_styles_page ($options);
    }
    break;
    
  case 'Fonts':
    ttftitles_fonts_page ($options);
    break;

  case 'Cache':
    ttftitles_cache_page ($options);
    break;

  case 'Usage':
    ttftitles_usage_page ($options);
    break;

  default: 
  }
  echo '</div>';
}



function ttftitles_styles_page ($options) {
  global $ttftitles_edit_labels, $ttftitles_default_styles;

  echo '<h2>Styles</h2>';
  echo '<a href="' . $_SERVER['PHP_SELF'] . '?page=ttftitles&action=edit+style&style_name=**NEW**" class="edit" title="Creates a new style definition">Add New Style</a>';
?>

<table class="widefat">
<thead>
<tr>
<th>Name</th>
<th>Values</th>
<th>Sample</th>
<th colspan="3">Actions</th>
</tr>
</thead>

<?php

   

 $styles = $options['styles'];

 if (count($styles) == 0) {
   $styles = $ttftitles_default_styles;
   $options['styles'] = $styles;
   ttftitles_save_settings ($options);
 }

 ksort ($styles);
 foreach ($styles as $name => $style) {
   $class = (($class == 'alternate') ? '' : 'alternate');
   if ($name == $options['default_style']) {
     $class .= ' active';
   }
   $css = ((empty($class)) ? '' : "class=\"$class\"");

   echo '<tr ' . $css .'><td>' . $name . '</td><td>';
   $first = true;
   foreach ($style as $key => $value) {
     list($label,$type,$extra) = $ttftitles_edit_labels[$key];
     if ($value) {
       if ($first) {
	 $first = false;
       } else {
	 echo ', ';
       }
       echo "<nobr>";
       if ($type == 'text') {
	 echo "<b>$label: </b>$value";
       } else if ($type == 'enum') {
	 if (is_array($extra)) {
	   $value = $extra[$value];
	 }
	 echo sprintf("<b>$label: </b> %s", $value);
       } else if ($type == 'number') {
	 echo sprintf("<b>$label: </b> %d", $value);
       } else if ($type == 'boolean') {
	 echo "<b>$label: </b>" . ($value ? 'TRUE' : 'FALSE');
       } else {
	 //	 echo "<b>$label: $key:</b> FOO";
       }
       echo "</nobr>";
     }
   }
   echo '</td>';
   echo '<td>' . ttftitles_render ($name, $name) . '</td>';
   echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?page=ttftitles&action=edit+style&style_name=' . "$name\" class=\"edit\" title=\"Edit the '$name' style definition\">Edit</a></td>";
   echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?page=ttftitles&action=delete+style&style_name=' . "$name\" class=\"edit\" title=\"Delete the '$name' style definition.\">Delete</a></td>";
   if ($options['default_style'] == $name) {
     echo '<td style="text-align:center;">Default Style</td>';
   } else {
     echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?page=ttftitles&action=default+style&style_name=' . "$name\" class=\"edit\" title=\"Make '$name' the default style.\">Make Default</a></td>";
   }
   echo '</tr>';
 }
 echo '</table>';

 echo '</div>';
}




function ttftitles_style_edit_page ($options) {
  global $ttftitles_default_styles;
  $stylename = $_REQUEST['style_name'];
  if ($stylename == "**NEW**") {
    $stylename = "YOU HAVE TO CHANGE THIS";
    $style_is_new = true;
    $style = $ttftitles_default_styles['basic'];
  } else {
    $style_is_new = false;
    $style = $options['styles'][$stylename];
  }
  if (!$style) {
    return false;
  }

?>


<h2>Edit Style</h2>

<form id="styleeditform" name="editform" action="<?php echo $_SERVER['PHP_SELF'] . '?page=ttftitles'; ?>" method="POST">

<input type="hidden" name="action" value="update style">

<div class="field">
  <label class="main" for="name">Style Name</label>
  <input type="text" id="name" name="style_name" size="20" value="<?php echo $stylename; echo '"'; if (!$style_is_new) { echo ' readonly';} ?> />
</div>

<div class="field">
  <label class="main" for="imagetype">Image Type</label>
  <select id="imagetype" name="image_type">
    <option value="png" <?php if ($style['image_type']=='png') { echo 'selected';} ?>>PNG</option>
    <option value="gif" <?php if ($style['image_type']=='gif') { echo ' selected';} ?>>GIF</option>
  </select>
</div>


<div class="field">
  <label class="main" for="font">Font Name</label>
  <select id="font" name="font_name">
<?php
$allfonts = ttftitles_get_font_list();
ksort ($allfonts);
foreach ($allfonts as $font => $fontfile) {
  if ($font === $style['font_name']) {
    echo "    <option selected value=\"$font\">$font</option>\n";
  } else {
    echo "    <option value=\"$font\">$font</option>\n";
  }
}
?>
</select>
</div>

<div class="field">
  <label class="main" for="fontsize">Font Size</label>
  <input type="text" id="fontsize" name="font_size" value="<?php echo $style['font_size']; ?>" size="3" />
</div>

<div class="field">
  <label class="main" for="fontcolor">Font Color</label>
  <input type="text" id="fontcolor" name="font_color" value="<?php echo $style['font_color']; ?>" size="7" />
</div>

<div class="field">
  <label class="main" for="lettercase">Letter Case</label>
  <select id="lettercase" name="letter_case">
<?php $cases = array ('unchanged' => 'unchanged',
                      'upper' => 'uppercase',
                      'lower' => 'lowercase',
                      'capital' => 'capitalize');
foreach ($cases as $value => $label) {
  echo "    <option value=\"$value\"";
  if ($style['letter_case'] == $value) { echo ' selected';}
  echo ">$label</option>";
}
?>
  </select>
</div>

<div class="field">
  <label class="main" for="bgcolor">BG Color</label>
  <input type="text" id="bgcolor" name="bg_color" value="<?php echo $style['bg_color']; ?>" size="7" />
</div>

<div class="field">
  <label class="main" for="bgtrans">Make BG Transparent?</label>
  <input type="checkbox" id="bgtrans" name="bg_transparent" <?php if ($style['bg_transparent']) {echo ' checked="checked"';} ?> />
</div>

<div class="field">
  <label class="main" for="bgimage">BG Image</label>
  <input type="text" id="bgimage" name="bg_image" value="<?php echo $style['bg_image']; ?>" size="50" />
</div>

<div class="field">
  <label class="main" for="indent">Left Indent</label>
  <input type="text" id="indent" name="indent" value="<?php echo $style['indent']; ?>" size="5" />
</div>

<div class="field">
  <label class="main" for="maxwidth">Maximum Width</label>
  <input type="text" id="maxwidth" name="maxwidth" value="<?php echo $style['maxwidth']; ?>" size="5" />
</div>

<div class="field">
  <label class="main" for="subindent">Subindent</label>
  <input type="text" id="subindent" name="subindent" value="<?php echo $style['subindent']; ?>" size="5" />
</div>

<div class="field">
  <label class="main" for="leading">Leading</label>
  <input type="text" id="leading" name="leading" value="<?php echo $style['leading']; ?>" size="5" />
</div>
<br /><br />

<div class="field">
  <label class="main" for="effectnone">No Effect</label>
  <input type="radio" id="effectnone" name="effect_type" value="none"
  <?php if ($style['effect_type'] == 'none') {echo ' checked';} ?>
/></div>

<br />
<div class="field">
  <label class="main" for="effectsoft">Soft Shadow</label>
  <input type="radio" id="effectsoft" name="effect_type" value="soft_shadow"
  <?php if ($style['effect_type'] == 'soft_shadow') {echo ' checked';} ?>
/></div>

<div class="field">
  <label class="sub" for="soft_shadow_color">Color</label>
  <input type="text" name="soft_shadow_color" id="soft_shadow_color" value="<?php echo $style['soft_shadow_color']; ?>" size="7">
</div>

<div class="field">
  <label class="sub" for="soft_shadow_spread">Spread</label>
  <input type="text" name="soft_shadow_spread" id="soft_shadow_spread" value="<?php echo $style['soft_shadow_spread']; ?>" size="7">
</div>

<div class="field">
  <label class="sub" for="soft_shadow_x_offset">X Offset</label>
  <input type="text" name="soft_shadow_x_offset" id="soft_shadow_x_offset" value="<?php echo $style['soft_shadow_x_offset']; ?>" size="7">
</div>

<div class="field">
  <label class="sub" for="soft_shadow_y_offset">Y Offset</label>
  <input type="text" name="soft_shadow_y_offset" id="soft_shadow_y_offset" value="<?php echo $style['soft_shadow_y_offset']; ?>" size="7">
</div>

<br/>

<div class="field">
  <label class="main" for="effecthard">Hard Shadow</label>
  <input type="radio" id="effecthard" name="effect_type" value="hard_shadow"
  <?php if ($style['effect_type'] == 'hard_shadow') {echo ' checked';} ?>
/></div>

<div class="field">
  <label class="sub" for="hard_shadow_color_2">Inner Color</label>
  <input type="text" name="hard_shadow_color_2" id="hard_shadow_color_2" value="<?php echo $style['hard_shadow_color_2']; ?>" size="7">
</div>

<div class="field">
  <label class="sub" for="hard_shadow_color_1">Outer Color</label>
  <input type="text" name="hard_shadow_color_1" id="hard_shadow_color_1" value="<?php echo $style['hard_shadow_color_1']; ?>" size="7">
</div>

<div class="field">
  <label class="sub" for="hard_shadow_offset">Offset</label>
  <input type="text" name="hard_shadow_offset" id="hard_shadow_offset" value="<?php echo $style['hard_shadow_offset']; ?>" size="4">
</div>
<br/>

<div class="field" style="text-align: right;"><label></label><input type="submit" class="button" value="<?php _e('Save Style') ?>" /></div>
</form>



<?php
  
  return true;

}



function ttftitles_cache_page ($options) {
?>
<h2>Cache Management</h2>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?page=ttftitles'; ?>" method="POST">
<input type="hidden" name="action" value="cache settings">

<div class="field"><label class="main" for="cachedir" title="Writable directory where generated images will be stored.">Cache Directory</label><input type="text" id="cachedir" name="cache_directory" style="width: 400px;" value="<?php echo $options['cache_directory'] ?>" /></div>

<div class="field"><label class="main" for="cacheurl" title="URL by which the cache directory can be reached.">Cache URL</label><input type="text" id="cacheurl" name="cache_url" style="width: 400px;" value="<?php echo $options['cache_url'] ?>"></div>

<div class="field"><label class="main" for="cachelifetime" title="How many days the cached images should live.">Cache Lifetime</label><input type="text" id="cachelifetime" name="cache_lifetime" style="width: 30px;" value="<?php echo $options['cache_lifetime'] ?>"></div>


<div class="field" style="text-align: right;"><label></label><input type="submit" class="button" value="<?php _e('Update Cache Settings') ?>" /></div>
</form>
<br>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?page=ttftitles'; ?>" method="POST">
<p style="margin-left: 100px; margin-right: 100px;">In theory, the cache should do its thing quietly and without any maintenance.  If for some reason things do go a little crazy, try clearing it out entirely and starting over:</p>
<input type="hidden" name="action" value="clear cache">
<input style="float: right;" class="button" type="submit" value="Clear Cache">
</form>
<div style="clear: both;"></div>
<?php 
}





function ttftitles_fonts_page ($options) {
?>
<h2>Font Management</h2>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?page=ttftitles'; ?>" method="POST">
<input type="hidden" name="action" value="font directory">
<div class="field"><label class="main" for="fontdir">Font Directory</label><input style="float: right;" class="button" type="submit" value="Save Font Directory"><input type="text" id="fontdir" name="font_directory" style="width: 400px;" value="<?php echo $options['font_directory'] ?>"></div>
</form>
<br>
<br>
<form action="<?php echo $_SERVER['PHP_SELF'] . '?page=ttftitles'; ?>" method="POST"  ENCTYPE="multipart/form-data">
<input type="hidden" name="action" value="font upload">
<div class="field"><label class="main" for="font_file">Font to Upload</label>
<input style="float: right;" class="button" type="submit" value="Upload Font">
<input id="font_file" name="font_file" type="file" size=40></div>
</form>

<h2>All Installed Fonts</h2>

<table class="widefat" style="width: 700px;">
<thead>
<tr>
<th>Font Name</th>
<th>Font File</th>
<th>Sample</th>
<th colspan="3">Actions</th>
</tr>
</thead>

<?php 
  $fonts = ttftitles_get_font_list ();
  ksort ($fonts);
$class = '';
  foreach ($fonts as $font_name => $font_file) {
   $class = (($class == 'alternate') ? '' : 'alternate');
    echo "<tr";
    if ($class) { echo " class=\"$class\"";}
    echo "><td>$font_name</td><td>" . basename($font_file) . "</td>";
    echo "<td style=\"overflow: hidden; width: 500px;\">";
    echo "<div style=\"overflow: hidden; width: 500px;\">";
    echo the_ttftext ($font_name,false,null,"font_name=$font_name&font_size=40&max_width=500&font_color=000&effect_type=none&bg_color=FFF&bg_transparent=true");
    echo "</div></td>\n";
    echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?page=ttftitles&action=delete+font&font_name=' . $font_name . '" class="edit" title="Deletes the font ' . "'$font_name' and the font file '" . basename($font_file) . "'.\">Delete</a></td>";

    echo "</tr>\n";
  }
?>
</table>
</div>
<?php
}


function ttftitles_usage_page ($options) {
?>
<h2>Template Tags (aka PHP Functions)</h2>
<p>This plugin provided two template tags (i.e. PHP functions) for use in your theme files.</p>

<h3>the_ttftitle ($before = "", $after = "", $echo = true, $style = "", $overrides = "")</h3>

<p>This is a replacement for <em>the_title</em> and should be used when you want to display the title of a post.  The first three arguments are the same as for <em>the_title</em>.  The $style and $overrides arguments are common to all TTFTitles template tags and are described below.</p>

<p>You should <strong>not</strong> use <em>the_ttftitle</em> if you are inserting the title into an attribute of an HTML tag.  It will break your pages.  For example, a common idiom for displaying a post's title is:</p>

<blockquote>
   &lt;a href="&lt;?php the_permalink() ?&gt;" rel="bookmark" title="Permanent Link to &lt;?php the_title(); ?&gt;"&gt;&lt;?php the_title(); ?&gt;&lt;/a&gt;
</blockquote>

    <p>    In this case, you should replace the second <em>the_title</em> (i.e. the own that is actually shown) and not the first, which is use to fill in the 'title' attribute of the anchor tag.  So, your result should look like this:</p>

<blockquote>
   &lt;a href="&lt;?php the_permalink() ?&gt;" rel="bookmark" title="Permanent Link to &lt;?php the_title(); ?&gt;"&gt;&lt;?php the_ttftitle(); ?&gt;&lt;/a&gt;
</blockquote>

<h3>the_ttftext ($text, $echo = true, $style="", $overrides="")</h3>

    <p>This is a more general text replacement tag.  $text can be any string you want to replace with an image.  For example, instead of displaying your blog's name with this:</p>

<blockquote>
&lt;?php get_bloginfo('name'); ?&gt;
</blockquote>

<p>You could use a nice text image with something like this:</p>

<blockquote>
&lt;?php the_ttftext(get_bloginfo('name')); ?&gt;
</blockquote>

<p><strong>Important Note:</strong> In earlier versions of this plugin, the $echo argument was not present.  When upgrading, please be careful of this if you are using either the $style or $overrides arguments.  Sorry.</p>

<h2>Common TTFTitles Arguments</h2>

<p>The <em>$style</em> argument should be the name of a style defined in the "Styles" tab.  You can use <em>null</em> for this argument to use the default style.</p>

<p>The <em>$overrides</em> argument can be used to override any of the parts of the style.  It should look like: name1=val1&amp;name2=val2&#8230; The variables you can override are:</p>


<table id="overrides">
<tr>
<th>Variable</th>
<th>Meaning</th>
<th>Example</th>
</tr>
<tr>
<td><em>image_type</em></td>
<td>the type of image</td>
<td>png or gif</td>
</tr>

<tr>
<td><em>font_name</em></td>
<td>the name of the font</td>
<td>Warp 1</td>
</tr>

<tr>
<td><em>font_size</em></td>
<td>the font size to use</td>
<td>24</td>
</tr>

<tr>
<td><em>font_color</em></td>
<td>the color of the text</td>
<td>#FF0000</td>
</tr>

<tr>
<td><em>letter_case</em></td>
<td>how to change the case of the text</td>
<td>unchanged, upper, lower, or capital</td>
</tr>

<tr>
<td><em>bg_color</em></td>
<td>the background color</td>
<td>#FFFFFF</td>
</tr>

<tr>
<td><em>bg_transparent</em></td>
<td>make the background transparent?</td>
<td>true</td>
</tr>

<tr>
<td><em>bg_image</em></td>
<td>an image to put in the background</td>
<td>null or a filename</td>
</tr>

<tr>
<td><em>indent</em></td>
<td>indent of the first line</td>
<td>5</td>
</tr>

<tr>
<td><em>maxwidth</em></td>
<td>how wide a line can be&#8230; 0 for no limit</td>
<td>500</td>
</tr>

<tr>
<td><em>subindent</em></td>
<td>indent for subsequent lines</td>
<td>20</td>
</tr>

<tr>
<td><em>leading</em></td>
<td>space between lines</td>
<td>10</td>
</tr>

<tr>
<td><em>effect_type</em></td>
<td>what kind of shadows?</td>
<td>none, hard_shadow, or soft_shadow</td>
</tr>

<tr>
<td><em>soft_shadow_color</em></td>
<td>the color of the soft shadow</td>
<td>#000000</td>
</tr>

<tr>
<td><em>soft_shadow_spread</em></td>
<td>how fuzzy the shadow is</td>
<td>5</td>
</tr>

<tr>
<td><em>soft_shadow_x_offset</em></td>
<td>horizontal offset of the shadow</td>
<td>3</td>
</tr>

<tr>
<td><em>soft_shadow_y_offset</em></td>
<td>vertical offset of the shadow</td>
<td>3</td>
</tr>

<tr>
<td><em>hard_shadow_color_1</em></td>
<td>hard shadow inside color</td>
<td>#FFFFFF</td>
</tr>

<tr>
<td><em>hard_shadow_color_2</em></td>
<td>hard shadow outside color</td>
<td>#000000</td>
</tr>

<tr>
<td><em>hard_shadow_offset</em></td>
<td>hard shadow offset</td>
<td>2</td>
</tr>
</table>

<?php
  return true;
}

?>
