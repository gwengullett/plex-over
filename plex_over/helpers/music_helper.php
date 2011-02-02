<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
 * itunes_url function.
 * 
 * @access public
 * @param mixed $url
 * @return void
 */
function itunes_url($url)
{
	return '/'.str_replace('itunes', 'iTunes', $url);	
}

/**
 * link_itunes function.
 * 
 * @access public
 * @param mixed $url
 * @param mixed $parent
 * @param mixed $item
 * @return void
 */
function link_itunes($url, $parent, $item)
{
	$link = (! isset($parent->key))
		? $url.'/'.$item->key 
		: $url.'/'.$parent->key.'/'.$item->key
	;
	return $link;
}