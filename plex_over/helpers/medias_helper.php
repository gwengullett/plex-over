<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// process $movie->details for lists
function movie_details($details = array())
{
	if (is_array($details) AND count($details) > 0)
	{
		foreach ($details as $detail)
		{
				$string[] = $detail->tag;
		}
		return implode(', ', $string);
	}
	return false;
}

//
function anchor_download($url, $size)
{
	$download_link = anchor('download'.$url, ' &#11015; '.byte_format($size), 'class="dl button dark-gradient rounded-st"');
	return $download_link;
}

// count global items season or album view: plex count 'all episodes'.... 
function childs_count($count = 0)
{
	return ($count > 1) ? ($count - 1) : $count;
}

// Create the link for episodes. We need the Parent id in
// order to get other episodes for our playlist
function link_episode($base, $segment)
{
	return implode('/', array_splice($base, 0, 3)).'/'.$segment;
}

function link_media($base, $item, $section_id)
{
	return site_url($base.'/'.$item.'/section/'.$section_id);
}