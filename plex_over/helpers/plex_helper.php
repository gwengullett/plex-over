<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// some helper functions

function active_item($send, $match, $class= 'selected')
{
	if ($send == $match) return $class;
}


// return tracks or movie length in minutes
function duration($seconds, $type = 'music')
{
	$seconds = substr($seconds, 0, -3);
	$m = (int)($seconds / 60); $s = $seconds % 60;	
	$h = (int)($m / 60); $m = $m % 60;
	
	return ($type == 'movie') ? $h.'h '.$m : $m.' : '.$s;
}

// --------------------------------------------------------------------
/**
 * alt_class function.
 * Sert à produire une class css de type 'alt' dans une boucle
 * Typiquement pour l'alternane des tableaux
 * 
 * @access public
 * @param mixed $key
 * @return String
 */
function css_alt($key, $class = ' alt ', $echo = true)
{
	// production
	if ($key % 2) {
		$alt = $class; 
	}
	else {
		$alt = '';
	}
	if (! $echo) return trim($alt);
	
	echo trim($alt); 
}

/**
 * anchor_topnav function.
 * Top nav libks : we just remove the last portion of our url
 * and replcae it with the desired view
 */
function anchor_topnav($base, $item)
{
	return anchor($base.'/'.$item->key, $item->title);
}


// generate a dropdown menu for navigation
function topnav_select($link, $filters, $segments)
{
	$menu = array(); $active = '';
	
	foreach ($filters->content as $item)
	{
	  $value = $link.'/'.$item->key;
	  $menu[$value] = lang(strtolower(strval($item->title)));
	  if (in_array($item->key, $segments)) $active = $value;
	}
	return form_dropdown('top_nav', $menu, $active, 'id="top_nav"');
}


// <img> configuration for the media main cover
function cover($image, $size = 150, $class = 'rounded shadow')
{
	if (is_array($image))
	{
		$size		= $image['size'];
		$image	=	(! $image['src']) ? $image['fallback'] : $image['src'];
	}
	return img(array(
		'src'		=> $image, 
		'width'	=> $size, 
		'class'	=> 'rounded shadow',
		'alt'		=> 'cover'
	));
}

// lookink for thumb or alternalivelly for art
// $force = skip testing and go on
function thumb($item, $force = null)
{
	if ($force) return $item->$force;
	
	if (isset($item->thumb))
	{
		return $item->thumb;
	}
	else if (isset($item->art))
	{
		return $item->art;
	}
	else if (isset($item->key) AND @getimagesize($item->key))
	{
		print_r(@getimagesize($item->key));
		return $item->key;
	}
	else
	{
		return '/:/resources/DefaultAlbumCover.png';
	}
}

/**
 * img_resize function.
 * 
 * @access public
 * @param mixed $server
 * @param mixed $rel_path
 * @param int $width. (default: 200)
 * @return void
 */
function img_resize($server, $rel_path, $width = 200)
{
	$transcode = '/photo/:/transcode?height='.$width.'&width='.$width.'&url=';
	$fullpath = $server.$transcode.urlencode($server.$rel_path);
	
	return $fullpath;
}
