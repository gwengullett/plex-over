<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plugin extends Plex {

	public function __construct()
	{
		parent::__construct('plugins');
	}
	
	/**
	 * scan function.
	 * Directory analyze...
	 * 
	 * @access public
	 * @param mixed $url. (default: null)
	 * @return void
	 */
	public function scan($url = null)
	{
		$items = $this->load($url);
		$return						= $this->get_attributes($items);
		$return->content	= $this->get_childrens($items);
		$return->view			= $this->get_view($items);
		$return->type			= $items->children()->getName();
		
		foreach ($return->content as $content)
		{
			//$key = explode('/', $content->key);
			//print_r(parse_url(end($key)));
		}
		
		return $return;
	}
	
	/**
	 * get_view function.
	 * Try to find the veiwGroup or Name of view
	 * 
	 * @access public
	 * @param mixed $item
	 * @return void
	 */
	public function get_view($item)
	{
		if (isset($item->attributes()->viewGroup))
		{
			return $item->attributes()->viewGroup;
		}
		else // get the Name of childs
		{
			return $item->children()->getName();
		}
	}
		
}