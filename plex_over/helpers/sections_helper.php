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
function link_item($base, $item)
{
	if (isset($item->type))
	{
		$link = strtolower($base).'/'.strtolower($item->type).'/'.$item->ratingKey;
	}
	else
	{
		$link = strtolower($base).'/'.strtolower($item->key);
	}
	
	return site_url($link);
}


/**
 * base_topnav function.
 * Rebuild a correct uri string to prepare top nav links
 */
function base_topnav($uri)
{
	return implode('/', array_splice($uri, 0, 4));
}