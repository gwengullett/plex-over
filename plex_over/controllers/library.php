<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Library extends PE_Controller {
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct(__CLASS__);
		$this->load->helper('sections');
	}
	
	/**
	 * index function.
	 * home page
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$data = $this->_prepare_links();
		$data['active_sb']		= $this->uri->segment(3);
		$data['items']				= $this->sidebar_library;
		foreach ($data['items']->content as $key => $item)
		{
			$item->addAttribute('ratingKey', $item->key.'/all');
		}
		$data['links']->item	= 'library/sections/';
		$data['link']					= 'library/sections';
		$this->breadcrumb[]		= '';
		$this->render('section/'.$this->section_view, $data);
	}
	
	/**
	 * sections function.
	 * we are at the root of library / section part.
	 * so we can start to load sections xml and the default section
	 * provided by the config file.
	 * 
	 * @access public
	 * @return void
	 */
	public function sections($section_type = 'movie')
	{		
		$data = $this->_prepare_links();
		$data['active_sb']	= $this->uri->segment(3);
		$data['link']				= 'medias';

		// Get section's content
		if (count($this->segments == 5))
		{
			$segments					= array_slice($this->uri->segment_array(), 3, 3);
			$filters					= $this->section->find(reset($segments));
			$data['items']		= $this->section->find_by($segments);
			$data['filters']	= $this->_top_nav($filters, $section_type);
			$data['active_sb'] .= '_'.$this->uri->segment(4);
			$this->breadcrumb[$data['links']->top_nav.'/all']	= $data['items']->title1;
		}
		if (count($this->segments) >= 8)
		{
			$bclink = $data['links']->top_nav.'/'.$this->uri->segment(5);
			$this->breadcrumb[$bclink] = $this->uri->segment(5);
		}
		$this->breadcrumb[] = @$data['items']->title2;
		// try to get correct back links for medias if secondary viewGroup is found
		// (actors don't even have a viewGroup property)
		if (! isset($data['items']->viewGroup) OR $data['items']->viewGroup == 'secondary')
		{
			$data['link'] = $this->uri->uri_string();
		}
		// here we come...
		$this->render('section/'.$this->section_view, $data);
	}
	
	
	/**
	 * prepare_links function.
	 * Just define links to send to the views...
	 * 
	 * @access private
	 * @return void
	 */
	private function _prepare_links()
	{
		$data['links'] = (object)array(
			'section' => $this->controller.'sections',
			'item'		=> 'medias',
			'top_nav'	=> base_topnav($this->segments)
		);
		return $data;
	}	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/home.php */