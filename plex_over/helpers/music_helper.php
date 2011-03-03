<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


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