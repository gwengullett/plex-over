<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// some helper functions

function active_item($send, $match, $class= 'active')
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
function css_alt($key, $class = ' alt ')
{
	$alt = ($key % 2) ? $class : '';
	
	return trim($alt); 
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
		return $item->key;
	}
	else
	{
		return '/:/resources/DefaultAlbumCover.png';
	}
}

function transcode_img($item, $opts = array(), $as_url = false)
{
	$ci = get_ci();
	
	return $ci->transcode->img($item, $opts, $as_url);
}



function get_ci()
{
	static $ci = false;
	
	if (! $ci) $ci =& get_instance();
	
	return $ci;
	
}
