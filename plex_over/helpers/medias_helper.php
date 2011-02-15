<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * movie_details function.
 * process $movie->details for lists
 * 
 * @access public
 * @param array $details. (default: array())
 * @param string $link. (default: '')
 * @return void
 */
function movie_details($details = array(), $link ='')
{
	$string = array();
	
	if (is_array($details) AND count($details) > 0)
	{
		foreach ($details as $key => $detail)
		{
			if (isset($detail->id)) $string[] = anchor($link.'/'.$detail->id, $detail->tag);
			if($key == 9) break;
		}
		
		return implode('<br />', $string);
	}
	return false;
}

/**
 * anchor_download function.
 * link the media to our dowbload controller to
 * force downloads
 * 
 * @access public
 * @param mixed $url
 * @param mixed $size
 * @return void
 */
function anchor_download($url, $size)
{
	$download_link = anchor('download'.$url, ' &#11015; '.byte_format($size));
	return $download_link;
}

/**
 * childs_count function.
 * count global items season or album view: plex count 'all episodes'.... 
 * 
 * @access public
 * @param int $count. (default: 0)
 * @return void
 */
function childs_count($count = 0)
{
	return ($count > 1) ? ($count - 1) : $count;
}

/**
 * link_episode function.
 * Create the link for episodes. We need the Parent id in
 * order to get other episodes for our playlist
 * 
 * @access public
 * @param mixed $base
 * @param mixed $segment
 * @return void
 */
function link_episode($base, $segment)
{
	return implode('/', array_splice($base, 0, 3)).'/'.$segment;
}

/**
 * link_media function.
 * to into section
 * 
 * @access public
 * @param mixed $base
 * @param mixed $item
 * @param mixed $section_id
 * @return void
 */
function link_media($base, $item, $section_id)
{
	return site_url($base.'/'.$item.'/section/'.$section_id);
}

/**
 * link_prod function.
 * translate production elements to existing filters if exists
 * 
 * @access public
 * @param mixed $el
 * @return void
 */
function link_prod($el)
{
	static $translators = array();
	if (! $translators) $translators = array('actor' => 'role');
	if (in_array($el, $translators)) $el = array_search($el, $translators);
	return $el;
}