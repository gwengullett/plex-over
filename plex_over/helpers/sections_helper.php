<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * anchor_section function.
 * Make a link to the current root section
 */
function link_section($base, $item)
{
	return site_url($base.'/'.$item->type.'/'.$item->key.'/all');
}

/**
 * link_item function.
 * Link for section content items
 */
function link_item($base, $item, $section_id = '')
{
	if (isset($item->type))
	{
		$link = $base.'/'.$item->type.'/'.$item->ratingKey;
	}
	else
	{
		$link = $base.'/'.$item->key;
	}
	$tail = ($section_id) ? '/section/'.$section_id : '';
	
	return site_url($link.$tail);
}

/**
 * base_topnav function.
 * Rebuild a correct uri string to prepare top nav links
 */
function base_topnav($uri)
{
	return implode('/', array_splice($uri, 0, 4));
}