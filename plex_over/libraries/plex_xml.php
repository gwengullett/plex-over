<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plex_xml {
	
	public $sections, $plex_url, $section_url, $meta_url, $segments, $home_url;
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param array $config. (default: array())
	 * @return void
	 */
	function __construct($config = array())
	{
		$this->initialize($config);
	}
	
	/**
	 * initialize function.
	 * 
	 * @access private
	 * @param mixed $config
	 * @return void
	 */
	private function initialize($config)
	{
		if (is_array($config) AND count($config) > 0)
		{
			foreach ($config as $key => $item)
			{
				$this->$key = $item;
			}
		}
		return $this->get_root_sections($this->plex_url.'/'.$this->section_url);
	}
	
	/**
	 * get_sections_root function.
	 * 
	 * @access private
	 * @return void
	 */
	public function get_root_sections($sections_path)
	{
		if ($sections = @simplexml_load_file($sections_path))
		{
			$this->sections = $sections;
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * get_section function.
	 * 
	 * @access public
	 * @param mixed $section_id. (default: null)
	 * @return void
	 */
	public function get_section($section_id = null, $view = 'all')
	{
		$data = array();
		
		foreach ($this->sections->Directory as $section)
		{
			if ($section->attributes()->key == (int)$section_id)
			{
				$data['section']= @simplexml_load_file($this->plex_url.'/'.$this->section_url.$section_id);
				$data['items']	= @simplexml_load_file($this->plex_url.'/'.$this->section_url.$section_id.'/'.$view);
				$data['title']	= (string)$section->attributes()->title;
				
				// We are looking for section views options and build an associativa array
				foreach ($data['section']->children() as $dir)
				{
					$data['filters'][(string)$dir->attributes()->key] = (string)$dir->attributes()->title;
				}
				return $data;
			}
		}
		return false;
	}
	
	/**
	 * get_media function.
	 * 
	 * @access public
	 * @param mixed $media_id
	 * @return void
	 */
	public function get_media($media_id)
	{
		$data = @simplexml_load_file($this->plex_url.'/'.$this->meta_url.$media_id);
		
		return $data;
	}
	
	/**
	 * get_media_by_uri function.
	 * 
	 * @access public
	 * @param mixed $uri
	 * @return void
	 */
	public function get_media_by_uri($uri)
	{
		return @simplexml_load_file($uri);
	}
	
	/**
	 * to_assoc function.
	 * iterate for nodes and build an associative array
	 * 
	 * @access public
	 * @param mixed $
	 * @return void
	 */
	public function section_to_assoc($node)
	{
		$array = array();
		
		foreach ($node->children() as $key => $item)
		{
			$array[(string)$item->attributes()->key]->type = (string)$item->attributes()->type;
			$array[(string)$item->attributes()->key]->title = (string)$item->attributes()->title;
		}
		
		return $array;
	}
	
}