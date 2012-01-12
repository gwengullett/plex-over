<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Section extends Plex {

	public function __construct()
	{
		parent::__construct($this->section_url);
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
		$items = $this->load($this->section_url.implode('/', $segments));
		$return						= $this->get_attributes($items);
		$return->content	= $this->get_childrens($items);
		return $return;
	}
	
	/**
	 * get_root function.
	 * get the starting section part
	 * 
	 * @access public
	 * @return void
	 */
	public function all()
	{
		$sections = $this->load($this->section_url);
		
		$return				= $this->get_attributes($sections);
		$return->content	= $this->get_childrens($sections);
		usort($return->content, array($this, 'sort_sections'));

		return $return;
	}
	
	
	/**
	 * sort_sections function.
	 * Sort sections by type.
	 * 
	 * @access private
	 * @return void
	 */
	private function sort_sections($k, $i)
	{
		return strcasecmp($k->type, $i->type);
	}
		
}