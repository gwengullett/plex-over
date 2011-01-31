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
		
		//$this->output->enable_profiler(true);
	}
	
	public function index()
	{
		redirect($this->controller.'sections');
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
		$this->load->helper('sections');
		
		$data = $this->_prepare_links();
		
		// Get section's content
		if (count($this->segments == 5))
		{
			$segments					= array_slice($this->uri->segment_array(), 3);
			$filters					= $this->section->find(reset($segments));
			$data['items']		= $this->section->find_by($segments);
			$data['filters']	= $this->_top_nav($filters, $section_type);
		}
		// try to get correct back links for medias if secondary viewGroup is found
		// (actors don't even have a viewGroup property)
		if (! isset($data['items']->viewGroup) OR $data['items']->viewGroup == 'secondary')
		{
			$data['links']->item = $this->uri->uri_string();
		}
		$data['active_sb']	= $this->uri->segment(3);
		$data['title']			= $data['items']->title1;
		// here we come...
		$this->render('section/index', $data);
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