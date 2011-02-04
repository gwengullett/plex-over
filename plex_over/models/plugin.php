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
		$return->keyname	= $items->children()->getName($items);
		
		// get url in something understandable for our app
		foreach ($return->content as $key => $content)
		{
			$params = explode('/:/', (string)$content->key);

			if (isset($params[1]))
			{
				// convert as segments
				$params[1] = implode('/', parse_url($params[1]));
				$content->addAttribute('pe_key', implode('/', $params));
			}
			// directory whitout base path
			else if (substr($content->key, 0, strlen($this->uri->segment(1))) != $this->uri->segment(1))
			{
				$params = $this->uri->uri_string().'/'.urlencode($content->key);
				$content->addAttribute('pe_key', $params);
			}
		}
		return $return;
	}
	
	/**
	 * scan_function function.
	 * Well now, we have to rebuild the uri for plex...
	 * 
	 * @access public
	 * @return void
	 */
	public function scan_function()
	{
		$segments = $this->segments;
		$base		= array_slice($segments, 0, 2);
		$base[] = ':/function';
		$end		= array(implode('?',  array_slice($segments, 3)));
		$final	= implode('/', array_merge($base, $end));
		
		return $this->scan($final);
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