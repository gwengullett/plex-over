<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function title($item)
{
	$maybe = array('album', 'artist', 'title', 'genre');
	
	foreach ($maybe as $title)
	{
		if (isset($item->$title)) return $item->$title;
	}
}

function itunes_url($url)
{
	return str_replace('itunes', 'iTunes', $url);	
}

function link_itunes($url, $parent, $item)
{
	$link = (! isset($parent->key))
		? $url.'/'.$item->key 
		: $url.'/'.$parent->key.'/'.$item->key
	;
	return $link;
}