<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plugins extends PE_Controller {
	
	public function __construct()
	{
		parent::__construct(__CLASS__);
		
		$this->load->model('plugin');
		$this->load->helper(array('plugins'));

		// viewGroup to CI views
		//$this->views->directory	= array('pictures', 'List');
		$this->views->infolist = array('Pictures', 'Details');
		$this->views->list = array('Coverflow');
		$this->view->track	= array('Album');
		
		// check for infolist and directory together
		$this->views->cat_lists	= array('List, Menu, InfoList');
	}
	
	/**
	 * index function.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$data['items']->content = $this->directory;
		$this->render('third/index', $data);
	}
	
	/**
	 * _remap function.
	 * 
	 * @access public
	 * @param mixed $arg
	 * @return void
	 */
	public function _remap($arg)
	{
		$this->directory = $this->plugin->directory('/'.$arg);
		
		if ($arg)
		{
			$this->breadcrumb[$this->controller] = lang($this->uri->segment(1));
			$data	= $this->_prepare_links();
			$data['title'] = __CLASS__.' | '.implode(' - ', $this->segments);
			$data['active_sb'] = $this->uri->segment(1);
			$this->load->vars($data);
			
			if ($this->uri->segment(3) == 'function')
			{
				$this->plugin_function($arg);
				return;
			}
			if ($this->uri->segment(2))
			{
				$this->plugin_directory($arg);
			}
			else
			{
				$this->index();
			}
		}
	}
	
	/**
	 * plugin_function function.
	 * We've passed the first level of the plugin... now
	 * let's see whats we get
	 * 
	 * @access public
	 * @param mixed $arg
	 * @return void
	 */
	public function plugin_function($arg)
	{
		$data['items'] = $this->plugin->scan_function($this->uri->uri_string());
		$this->breadcrumb[] = $data['items']->title1;
		//print_r($data['items']);
		if (! in_array($data['items']->view, $this->views->cat_lists) AND $data['items']->keyname == 'Directory')
		{
			$data['items']->view = 'List';
		}
		$this->render('third/sub_index', $data);
	}
	
	/**
	 * plugin_directory function.
	 * 
	 * @access public
	 * @param mixed $arg
	 * @return void
	 */
	public function plugin_directory($arg)
	{
		$data['items'] = $this->plugin->scan($this->uri->uri_string());
				//print_r($data['items']);

		$this->breadcrumb[] = $data['items']->title1;

		// the model should return us the view group...
		$this->render('third/sub_index', $data);
	}

	/**
	 * _viewgroup function.
	 * redirect to similar views
	 * 
	 * @access private
	 * @return void
	 */
	private function _viewgroup($view)
	{
		foreach ($this->views as $key => $group)
		{
			if (in_array($view, $group)) return $key;
		}
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
		$segments = $this->segments;
		if (count($segments) > 2) array_pop($segments);
		$data['links'] = (object)array(
			'section' => 'library/sections',
			'item'		=> $this->uri->segment(1)
		);
		return $data;
	}	
	
}