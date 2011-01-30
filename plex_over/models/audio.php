<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Audio extends Plex {
	
	public function __construct()
	{
		// the contructor takes the first plex url segment
		parent::__construct('music');
		
	}
		
		/**
	 * find function.
	 * find a single section, mainly to get directory views
	 * 
	 * @access public
	 * @param mixed $id. (default: null)
	 * @return void
	 */
	function album($segments)
	{
		if ($segments)
		{
			$item = $this->load('music/'.$segments);
			$album = $this->get_attributes($item);
			
			foreach ($item->children() as $key => $track)
			{
				$album->albums[0]->tracks[] = $track->attributes();
			}
			//print_r($album);
			return $album;
		}
		return false;
	}

	
	/**
	 * content function.
	 * Get the content of an Artist, playlist etc...
	 * 
	 * @access public
	 * @param mixed $url
	 * @return void
	 */
	public function content($url, $type = '')
	{
		$music = $this->find($url);
		// get sub items
		foreach ($music->content as $key => $item)
		{
			// set as common opbject to inherit tracks from albums
			foreach ($item as $name => $attribute)
			{
				$music->albums[$key]->$name = $attribute;
			}
			// get tracks
			$music->albums[$key]->tracks = $this->get_childrens($this->load('music'.$url.'/'.$item->key));

		}
		// remove albums from object, there are refenced into album array...
		unset($music->content);
		return $music;
	}
	
	/**
	 * load function.
	 * Cause url are case sensitive...
	 * 
	 * @access public
	 * @param mixed $args
	 * @return void
	 */
	public function load($args)
	{
		if (strpos($args, 'itunes'))
		{
			$args = str_replace('itunes', 'iTunes', $args);
		}
		
		return parent::load($args);
	}


	
}