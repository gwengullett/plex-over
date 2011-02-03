<?php

/**
 * link_plugin function.
 * try our link before...
 * 
 * @access public
 * @param mixed $item
 * @return void
 */

function link_plugin($item, $plex_url = '')
{
	return (isset($item->pe_key)) ? $item->pe_key :$item->key;
}

/**
 * dispatch_views function.
 * Group views
 * 
 * @access public
 * @param mixed $view
 * @param mixed $view_groups
 * @return void
 */
function dispatch_views($view, $view_groups)
{
	foreach ($view_groups as $key => $group)
	{
		if (in_array($view, $group))
		{
			$view = $key;
		}
	}
	
	return strtolower($view);
}

// if we pass plex_url, we are looking for a base domain
function link_server($url, $plex_url)
{
	if (substr($url, 0, 7) != 'http://')
	{
		$url = $plex_url.$url;
	}
	return $url;
}