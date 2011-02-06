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
function dispatch_views($item, $view_groups)
{
	if ($item->keyname == 'Track')
	{
		return strtolower($item->keyname);
	}
	else if ($item->keyname == 'Directory')
	{
		return 'list';
	}
	foreach ($view_groups as $key => $group)
	{
		if (in_array((string)$item->view, $group) OR in_array((string)$item->keyname, $group))
		{
			$item->view = $key;
		}
	}
	if (! $item->view AND ! $item->keyname )
	{
		$item->view = plugin_error($item);
	}
	
	return strtolower($item->view);
}

/**
 * plugin_error function.
 * We can't serve the current page
 * TODO: send a modal view here
 * 
 * @access public
 * @param mixed $item
 * @return void
 */
function plugin_error($item)
{
	return 'error';
}

/**
 * link_server function.
 * if we pass plex_url, we are looking for a base domain
 * 
 * @access public
 * @param mixed $url
 * @param mixed $plex_url
 * @return void
 */
function link_server($url, $plex_url)
{
	$url = trim((string)$url);
	
	if (! $url) return 'images/blank.png';
	
	if ($link = is_plex_link($url))
	{
		$url = str_replace($link, $plex_url, $url);
	}
	else if (is_relative_link($url))
	{
		$url = $plex_url.$url;
	}
	return $url;
}

/**
 * check_link function.
 * check if links are external or not
 * 
 * @access public
 * @return void
 */
function is_relative_link($url)
{
	if (substr($url, 0, 7) != 'http://')
	{
		return true;
	}
	return false;
}

/**
 * is_internal_link function.
 * 
 * @access public
 * @param mixed $url
 * @return void
 */
function is_plex_link($url)
{
	if (substr(trim($url), 0, 16) == 'plex://127.0.0.1')
	{
		return 'plex://127.0.0.1';
	}
	return false;
}

/**
 * is_internal_link function.
 * 
 * @access public
 * @param mixed $url
 * @param mixed $plex_url
 * @return void
 */
function is_internal_link($url, $plex_url)
{
	if (substr(trim($url), 0, strlen($plex_url)) == $plex_url)
	{
		return true;
	}
	return false;
}

/**
 * is_online_request function.
 * 
 * @access public
 * @param mixed $url
 * @return void
 */
function is_online_request($url)
{
	if (strpos(urldecode($url), 'plexapp.com/player'))
	{
		return true;
	}
	return false;
}

/**
 * is_plex_player function.
 * 
 * @access public
 * @param mixed $url
 * @return void
 */
function is_plex_player($url)
{
	if (strpos(urldecode($url), 'www.plexapp.com/player/player.php'))
	{
		$temp_url = explode('url=', urldecode($url));
		return urldecode(end($temp_url));
	}
	return false;
}

/**
 * parse_online_request function.
 * 
 * @access public
 * @param mixed $url
 * @return void
 */
function parse_online_request($url)
{
	$params				= @preg_split('/[&|?]/', $url);
	$output->url	= array_shift($params);
	
	if (count($params > 0))
	{
	  foreach ($params as $param)
	  {
	  	$array = explode('=', $param);
	  	$output->{$array[0]} = (isset($array[1])) ? $array[1] : '';
	  }
	}
	return $output;
}

/**
 * parse_rtmp function.
 * parse rtmp for flowplayer
 *
 * @access public
 * @param mixed $url
 * @return void
 */
function parse_stream($url)
{
	if (is_internal_link(trim($url)))
	{
		$url = is_plex_player($url);
	}
	$exploded = explode('clip=', $url);
	
	if (isset($exploded[1]))
	{
		$params = explode('&', $exploded[1]);
		$base = preg_split('/[&|?]/', $exploded[0], null);
		
		$out['connexion_url'] = $base[0];
		$out['url']	= array_shift($params);
		
		// url to pass
		if (count($params > 0))
		{
			foreach ($params as $param)
			{
				$array = explode('=', $param);
				$out[$array[0]] = (isset($array[1])) ? $array[1] : '';
			}
		}
		return $out;
	}
	
	else
	{
		return $url;
	}
}

