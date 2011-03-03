<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * active_item function.
 * used to add active css class by comparaison
 * 
 * @access public
 * @param mixed $send
 * @param mixed $match
 * @param string $class. (default: 'active')
 * @return void
 */
function active_item($send, $match, $class= 'active')
{
	if ($send == $match) return $class;
}

/**
 * split_summary function.
 * Split summary by sentence whitout cutting words
 * 
 * @access public
 * @param string $text. (default: '')
 * @return void
 */
function split_summary($text = '')
{
	$length = 400;
	
	if (strlen($text) > $length)
	{
		$parts		= str_split($text,  strrpos(substr($text, 0, $length), '.')+1);
		$summary	= array_shift($parts);
		$text			= $summary.'<span style="display:none">'.implode('', $parts).'</span>';
		$text		 .= '<strong><a class="button rounded gradient">'.lang('read_more').'</a></strong>';
	}
	return nl2br($text);
}

/**
 * duration function.
 * return tracks or movie length in minutes
 * 
 * @access public
 * @param mixed $seconds
 * @param string $type. (default: 'music')
 * @return void
 */
function duration($seconds, $type = 'music')
{
	$seconds = substr($seconds, 0, -3);
	$m = (int)($seconds / 60); $s = $seconds % 60;	
	$h = (int)($m / 60); $m = $m % 60;
	
	return ($type == 'movie') ? $h.'h '.$m : $m.' : '.$s;
}

/**
 * alt_class function.
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

/**
 * topnav_select function.
 * generate a dropdown menu for navigation
 * 
 * @access public
 * @param mixed $link
 * @param mixed $filters
 * @param mixed $segments
 * @return void
 */
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


/**
 * thumb function.
 * lookink for thumb or alternalivelly for art
 * $force = skip testing and go on
 * 
 * @access public
 * @param mixed $item
 * @param mixed $force. (default: null)
 * @return void
 */
function thumb($item, $force = null)
{
	if ($force)
		return $item->$force;
	
	if (isset($item->thumb))
		return $item->thumb;
	
	else if (isset($item->art))
		return $item->art;

	else if (isset($item->key) AND @getimagesize($item->key))
		return $item->key;

	else
		return '/:/resources/DefaultAlbumCover.png';
}

/**
 * transcode_img function.
 * shortcut to transcode library
 * 
 * @access public
 * @param mixed $item
 * @param array $opts. (default: array())
 * @param bool $as_url. (default: false)
 * @return void
 */
function transcode_img($item, $opts = array(), $as_url = false)
{
	$ci = get_ci();
	
	return $ci->transcode->img($item, $opts, $as_url);
}

/**
 * title function.
 * 
 * @access public
 * @param mixed $item
 * @return void
 */
function title($item)
{
	$maybe = array('album', 'artist', 'title', 'genre');
	
	foreach ($maybe as $title)
	{
		if (isset($item->$title)) return $item->$title;
	}
}


/**
 * get_ci function.
 * Call Codeigniter instance
 * 
 * @access public
 * @return void
 */
function get_ci()
{
	static $ci = false;
	
	if (! $ci) $ci =& get_instance();
	
	return $ci;
	
}
