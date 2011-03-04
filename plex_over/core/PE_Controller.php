<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PE_Controller extends CI_Controller {
	
	public function __construct($class)
	{
		parent::__construct();
		
		if ($class) $this->controller = strtolower($class).'/';
		
		$this->initialize();
	}
	
	/**
	 * initialize function.
	 * Initialze some shared properties
	 * 
	 * @access private
	 * @return void
	 */
	private function initialize()
	{
		$this->plex_url			= $this->config->item('plex_url');
		$this->plex_local		= $this->config->item('plex_local');
		$this->section_url	= $this->config->item('section_url');
		$this->meta_url			= $this->config->item('meta_url');
		$this->home_url			= $this->config->item('home_section');
		$this->template			= $this->config->item('template');
		$this->section_view	= ($cookie = $this->input->cookie('po_section_view')) ? $cookie : 'grid';
				
		// create a segment object
		$this->segments = $this->uri->segment_array();
		
		// Cache cannot handle POST requests (ajax test: for videos in plugins).
		if ($_POST AND $this->input->is_ajax_request())
		{
			$this->config->set_item('cache_expire', '');
		}
		// set the cache if defined in config
		if ($cache_dur = $this->config->item('cache_expire') AND is_numeric($cache_dur))
		{
			$this->output->cache($cache_dur);
		}
		if (is_bool($this->config->item('debug_ci')))
		{
			$this->output->enable_profiler($this->config->item('debug_ci'));
		}
		// load base xml
		$this->load_base();
	}
		
	/**
	 * load_base function.
	 * Load xml for sidebar. 
	 * 
	 * @access private
	 * @return void
	 */
	private function load_base()
	{
		$this->load->model('section');

		$this->sidebar_library	= $this->section->all();
		$this->sidebar_third		= $this->plex->third_party();
	}
	
	/**
	 * render function.
	 * Render main template
	 * 
	 * @access protected
	 * @param mixed $view
	 * @param array $data. (default: array())
	 * @return void
	 */
	protected function render($view, $data = array())
	{
		$data['sections']			= $this->sidebar_library;
		$data['third_party'] 	= $this->sidebar_third;
		$data['title']			 	= implode(' - ', $this->breadcrumb);

		$this->load->vars($data);
		$this->load->view($this->template.'/layouts/head');
		$this->load->view($this->template.'/layouts/sidebar');
		$this->load->view($this->template.'/'.$view);

	}
	
	/**
	 * render_ajax function.
	 * Juste return a json string
	 * 
	 * @access public
	 * @param mixed $to_parse
	 * @return void
	 */
	public function render_ajax($to_render)
	{
		$this->output->set_output(json_encode($to_render));
	}
	
	/**
	 * _top_nav function.
	 * We just add some links to filter view. Filters are
	 * defined in plex_explorer config file.
	 * 
	 * @access private
	 * @return void
	 */
	protected function _top_nav($items, $section_type)
	{
		// load the item corresponding to the group
		$filters = $this->config->item($section_type.'_filters');
		// loop and unset undesired entries
		if ($filters !== false AND count($items->content) > 0)
		{
			foreach ($items->content as $key => $attr)
			{
				if (! in_array(strtolower($attr->key), $filters)) unset($items->content[$key]);
			}
		}
		return $items;
	}

	
	/**
	 * topnav_view function.
	 * get the top nav view
	 * 
	 * @access protected
	 * @return void
	 */
	protected function topnav_view($data = array())
	{
		return $this->load->view($this->template.'/layouts/top_nav', $data, true);
	}
}