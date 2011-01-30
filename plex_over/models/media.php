<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends Plex {

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * find function.
	 * 
	 * @access public
	 * @param mixed $id. (default: null)
	 * @return void
	 */
	function find_details($id = null)
	{
		if ($id)
		{
			$item = $this->load($this->meta_url.$id);
			if (isset($item->Video))
			{
				$movie					= $this->get_attributes($item->Video);
				$movie->details	= $this->get_details($item->Video);
				$movie->media		= array_shift($movie->details);
				$movie->attributes = $this->get_attributes($item->Video->Media);
				return $movie;
			}
		}
		return false;
	}
	
	/**
	 * get_childrens_recursive function.
	 * 
	 * @access public
	 * @param mixed $item
	 * @param mixed $out. (default: null)
	 * @return void
	 */
	function get_details($item, $out = null)
	{
		foreach ($item->children() as $key => $child)
		{
			$key = strtolower($key);

			if (count($child) > 0)
			{
				foreach ($child->children() as $sub => $el)
				{
					$out[$key]->{strtolower($sub)}[] = $this->get_attributes($el);
				}
			}
			else
			{
				$out[$key][] = $this->get_attributes($child);
			}
		}
		return $out;
	}
	
	/**
	 * find function.
	 * find a single section, mainly to get directory views
	 * 
	 * @access public
	 * @param mixed $id. (default: null)
	 * @return void
	 */
	function find_children($id = null)
	{
		if ($id)
		{
			$item = $this->load($this->meta_url.$id.'/children');
			return $this->normalize($item);
		}
		return false;
	}
	
	/**
	 * items function.
	 * Get the content of a section, by it's id and view
	 * 
	 * @access public
	 * @param array $segments. (default: array())
	 * @return void
	 */
	public function find_by($segments = array())
	{
		$item		= $this->load($this->meta_url.implode('/', $segments));
		$return = $this->get_attributes($item);
		$return->media = $item->Media->children();
		
		return $return;
	}

}