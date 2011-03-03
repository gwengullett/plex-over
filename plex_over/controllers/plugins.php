<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plugins extends PE_Controller {
	
	public function __construct()
	{
		parent::__construct(__CLASS__);
		
		$this->load->model('plugin');
		$this->load->helper(array('plugins'));

		// viewGroup to CI views
		//$this->views->directory	= array('pictures', 'List');
		$this->views->infolist	= array('Pictures', 'Details', 'Video', 'PhotoList', 'Photos');
		$this->views->list			= array('Coverflow', 'Photolist');
		$this->view->track			= array('Album', 'Track');
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
		$data['link'] = $this->uri->segment(1);
		$this->render('section/'.$this->section_view, $data);
	}
	
	/**
	 * _remap function.
	 * 
	 * @access public
	 * @param mixed $arg
	 * @return void
	 */
	public function _remap($directory)
	{
		$this->directory = $this->plugin->directory('/'.$directory);
		
		if ($directory AND ! $this->plugin_hook($directory))
		{
			$this->breadcrumb[$directory] = lang($this->uri->segment(1));
			$data	= $this->_prepare_links();
			$data['title'] = __CLASS__.' | '.implode(' - ', $this->segments);
			$data['active_sb'] = $directory;
			$this->load->vars($data);
			
			if ($this->uri->segment(3) == 'function')
			{
				$this->plugin_function($directory);
				return;
			}
			if ($this->uri->segment(2))
			{
				$this->plugin_directory($directory);
			}
			else
			{
				$this->index();
			}
		}
	}
	
	/**
	 * plugin_hook function.
	 * 
	 * @access private
	 * @param mixed $directory
	 * @return void
	 */
	private function plugin_hook($directory)
	{
		$plugin_name = $this->uri->segment(2);
		$path = '/third/'.strtolower($plugin_name);
		if (file_exists(dirname(__FILE__).$path.EXT))
		{
			redirect($path);
		}
		else
		{
			return false;
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
		$bcbase = $arg.'/'.$this->uri->segment(2);
		$this->breadcrumb[$bcbase] = @$data['items']->title1;
		$this->breadcrumb[] = @$data['items']->title2;
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