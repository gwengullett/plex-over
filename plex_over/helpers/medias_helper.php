<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// process $movie->details for lists
function movie_details($details = array(), $link ='')
{
	if (is_array($details) AND count($details) > 0)
	{
		foreach ($details as $key => $detail)
		{
			$string[] = anchor($link.'/'.$detail->id, $detail->tag);
			if($key == 9) break;
		}
		return implode('<br />', $string);
	}
	return false;
}

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

// to into section
function link_media($base, $item, $section_id)
{
	return site_url($base.'/'.$item.'/section/'.$section_id);
}

// translate production elements to existing filters if exists
function link_prod($el)
{
	static $translators = array();
	if (! $translators) $translators = array('actor' => 'role');
	if (in_array($el, $translators)) $el = array_search($el, $translators);
	return $el;
}